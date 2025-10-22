<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseItemRequest;
use App\Http\Requests\UpdatePurchaseItemRequest;
use App\Http\Resources\PurchaseItemResource;
use App\Models\PurchaseItem;
use App\Models\Product;
use Illuminate\Support\Str;

class PurchaseItemController extends Controller
{
    public function index()
    {
        return PurchaseItemResource::collection(PurchaseItem::with('product')->get());
    }

    public function store(StorePurchaseItemRequest $request)
    {
        // Get the product to fetch its price
        $product = Product::findOrFail($request->product_id);

        $item = PurchaseItem::create([
            'id' => Str::uuid(),
            'purchase_id' => $request->purchase_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $product->price, // <-- set price explicitly
        ]);

        return new PurchaseItemResource($item->load('product'));
    }

    public function show(PurchaseItem $purchaseItem)
    {
        return new PurchaseItemResource($purchaseItem->load('product'));
    }

    public function update(UpdatePurchaseItemRequest $request, PurchaseItem $purchaseItem)

    {
        // Get the product to fetch its price
        $product = Product::findOrFail($request->product_id);

        $purchaseItem->update([
            'purchase_id' => $request->purchase_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $product->price, // <-- update price explicitly
        ]);

        return new PurchaseItemResource($purchaseItem->load('product'));
    }

    public function destroy(PurchaseItem $purchaseItem)
    {
        $purchaseItem->delete();
        return response()->noContent();
    }
}
