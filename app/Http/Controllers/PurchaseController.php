<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('items.product')->get();
        return PurchaseResource::collection($purchases);
    }

    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create the purchase
            $purchase = Purchase::create([
                'id' => Str::uuid(),
                'user_id' => $request->user_id,
                'total_amount' => 0, // will calculate after adding items
                'status' => $request->status ?? 'pending',
            ]);

            $totalAmount = 0;

            foreach ($request->items as $item) {
                // Get product to fetch price
                $product = Product::findOrFail($item['product_id']);

                // Create purchase item with price
                $purchaseItem = PurchaseItem::create([
                    'id' => Str::uuid(),
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price, // important!
                ]);

                $totalAmount += $product->price * $item['quantity'];
            }

            // Update total amount
            $purchase->update(['total_amount' => $totalAmount]);

            DB::commit();

            return new PurchaseResource($purchase->load('items.product'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Purchase creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Purchase $purchase)
    {
        return new PurchaseResource($purchase->load('items.product'));
    }

    public function update(StorePurchaseRequest $request, Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            // Delete old items
            $purchase->items()->delete();

            $totalAmount = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                PurchaseItem::create([
                    'id' => Str::uuid(),
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $totalAmount += $product->price * $item['quantity'];
            }

            $purchase->update([
                'total_amount' => $totalAmount,
                'status' => $request->status ?? $purchase->status,
            ]);

            DB::commit();

            return new PurchaseResource($purchase->load('items.product'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Purchase update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->items()->delete();
        $purchase->delete();

        return response()->json(['message' => 'Purchase deleted successfully.']);
    }
}
