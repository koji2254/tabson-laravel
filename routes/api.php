<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Models\CartItems;
use App\Models\Products;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('products', [ProductsController::class, 'allProducts']);

Route::get('product/{id}', [ProductsController::class, 'singleProduct']);

Route::post('product/add', [ProductsController::class, 'addProduct'])->name('addProduct');

Route::post('product/update-product', [ProductsController::class, 'editProduct'])->name('editProduct');

Route::delete('product/{id}', [ProductsController::class, 'deleteProduct'])->name('deleteProduct');


Route::post('save-cart-info', [CartController::class, 'saveItemsToHistory']);

Route::get('history-list', [CartController::class, 'historyList']);

Route::get('history-cart/{cartId}', [CartController::class, 'historyCart']);

Route::delete('delete-invoice/{cartId}', [CartController::class, 'deleteInvoice']);