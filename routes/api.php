<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;

Route::get('/test', function() {
    return response()->json(['message' => 'API is working!']);
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes that require login
Route::middleware('auth:api')->group(function () {

    // USERS
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:view_users');
    Route::post('/users', [UserController::class, 'store'])->middleware('permission:create_users');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('permission:view_users');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('permission:update_users');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('permission:delete_users');

    // CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index'])->middleware('permission:view_categories');
    Route::post('/categories', [CategoryController::class, 'store'])->middleware('permission:create_categories');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->middleware('permission:view_categories');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware('permission:update_categories');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('permission:delete_categories');

    // SUBCATEGORIES
    Route::get('/subcategories', [SubcategoryController::class, 'index'])->middleware('permission:view_subcategories');
    Route::post('/subcategories', [SubcategoryController::class, 'store'])->middleware('permission:create_subcategories');
    Route::get('/subcategories/{subcategory}', [SubcategoryController::class, 'show'])->middleware('permission:view_subcategories');
    Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->middleware('permission:update_subcategories');
    Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->middleware('permission:delete_subcategories');

    // PRODUCTS
    Route::get('/products', [ProductController::class, 'index'])->middleware('permission:view_product');
    Route::post('/products', [ProductController::class, 'store'])->middleware('permission:create_product');
    Route::get('/products/{product}', [ProductController::class, 'show'])->middleware('permission:view_product');
    Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('permission:update_product');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware('permission:delete_product');

    // PURCHASES
    Route::get('/purchases', [PurchaseController::class, 'index'])->middleware('permission:view_purchase');
    Route::post('/purchases', [PurchaseController::class, 'store'])->middleware('permission:create_purchase');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->middleware('permission:view_purchase');
    Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])->middleware('permission:update_purchase');
    Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->middleware('permission:delete_purchase');

    // PURCHASE ITEMS
    Route::get('/purchase-items', [PurchaseItemController::class, 'index'])->middleware('permission:view_purchase_items');
    Route::post('/purchase-items', [PurchaseItemController::class, 'store'])->middleware('permission:create_purchase_items');
    Route::get('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'show'])->middleware('permission:view_purchase_items');
    Route::put('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'update'])->middleware('permission:update_purchase_items');
    Route::delete('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'destroy'])->middleware('permission:delete_purchase_items');
});
