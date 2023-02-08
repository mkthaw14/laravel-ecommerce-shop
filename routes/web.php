<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/", [ShopController::class, "index"])->name("shop");
Route::get("/shop/cart", [ShopController::class, "cart"])->name("shop.cart");
Route::get("/shop/login", [ShopController::class, "login"])->name("shop.login");
Route::get("/shop/get-product-by-category", [ShopController::class, "getProductByCategory"])->name("shop.get-product-by-category");

Route::middleware("auth")->group(function() {
    Route::get("/shop/check-out", [ShopController::class, "checkOut"])->name("shop.check-out");
    Route::post("/shop/place-order", [ShopController::class, "placeOrder"])->name("shop.place-order");
});

Route::middleware("auth", "role:admin")->group(function() {
    Route::get("/category/get-category", [CategoryController::class, "getCategory"])->name("category.get-category");
    Route::resource("category", CategoryController::class);

    Route::get("/product/get-product", [ProductController::class, "getProduct"])->name("product.get-product");
    Route::resource("product", ProductController::class);

    Route::get("/order/get-order", [OrderController::class, "getOrder"])->name("order.get-order");
    Route::patch("/order/update-status/{order}", [OrderController::class, "updateStatus"])->name("order.update-status");
    Route::patch("/order/status-cancel/{order}", [OrderController::class, "statusCancel"])->name("order.status-cancel");
    Route::resource("order", OrderController::class);
});



Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
