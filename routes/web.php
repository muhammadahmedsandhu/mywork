<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/',[FrontendController::class,"index"])->name("home");


Auth::routes();

Route::get("/admin",function(){

    return redirect()->to(route("create-page"));

});

Route::group(["prefix"=>"admin","middleware"=>"auth"],function(){

    Route::get("/create-product",[ProductController::class,"createPage"])->name("create-page");
    Route::post("/create-product",[ProductController::class,"storeProduct"]);

    Route::get("/product-list",[ProductController::class,"listPage"])->name("list-page");

    Route::get("/edit-product/{id}",[ProductController::class,"editPage"])->name("edit-page");
    Route::post("/update-product",[ProductController::class,"update"])->name("update-product");

    Route::get("/delete-product/{id}",[ProductController::class,"delete"])->name("delete-product");

});



