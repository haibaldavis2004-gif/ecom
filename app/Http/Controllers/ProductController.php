<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    // 1️⃣ List all products
    public function index()
    {
        // Fix: load subcategory and category through subcategory
        $products = Product::with('subcategory.category')->get();
        return ProductResource::collection($products);
    }

    // 2️⃣ Store a new product
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        // Load the relations after creation
        $product->load('subcategory.category');

        return new ProductResource($product);
    }

    // 3️⃣ Show a single product
    public function show(Product $product)
    {
        $product->load('subcategory.category'); // Fix: load through subcategory
        return new ProductResource($product);
    }

    // 4️⃣ Update a product
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->load('subcategory.category'); // Fix
        return new ProductResource($product);
    }

    // 5️⃣ Delete a product
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}

