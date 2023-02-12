<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectBidController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

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
Route::get('/expired-products',[FrontendController::class,"expiredProducts"])->name("expired-products");
Route::get('/project/{id}',[ProjectBidController::class,"project"])->name("project");
Route::get('/view-projects/{id}',[FrontendController::class,"projects"])->name("projects");
Route::get("/verify", [RegisterController::class, "verifyUser"])->name("verify.user");

Auth::routes(); 

Route::get("/admin",function(){

    return redirect()->to(route("create-page"));

});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get("/create-product",[ProductController::class,"createPage"])->name("create-page");
    Route::post("/create-product",[ProductController::class,"storeProduct"]);

    Route::get("/product-list",[ProductController::class,"listPage"])->name("list-page");
    Route::get("/expired-product-list",[ProductController::class,"expiredProductList"])->name("expired-list-page");

    Route::get("/project-list/{id}",[ProductController::class,"projectList"])->name("project-list");
    Route::get("/edit-product/{id}",[ProductController::class,"editPage"])->name("edit-page");
    Route::post("/update-product",[ProductController::class,"update"])->name("update-product");
    Route::get("/delete-product/{id}",[ProductController::class,"delete"])->name("delete-product");

    Route::post("/update-project-status",[ProjectBidController::class,"updateStatus"])->name("update-project-status");

    // ************** User Management ************** //
    Route::get("/user-list",[UserController::class,"userList"])->name("user-page");
    Route::get("/block-user/{id}",[UserController::class,"blockUser"])->name("block-user");
    Route::get("/unblock-user/{id}",[UserController::class,"unblockUser"])->name("unblock-user");
    Route::get("/user-projects/{id}",[UserController::class,"userProjects"])->name("user-projects");
    Route::post("/update-payment-status",[UserController::class,"updatePaymentStatus"])->name("update-payment-status");
});

Route::middleware(['auth'])->group(function () {
    Route::get('/project/{id}',[ProjectBidController::class,"project"])->name("project");
    Route::post('/submit-project',[ProjectBidController::class,"submitProject"])->name("submit-project");
    Route::get('/profile', [ProfileController::class, "index"])->name("profile");
    Route::post('/save-profile', [ProfileController::class, "saveProfile"])->name("save-profile");
    Route::get('/user-dashboard', [ProfileController::class, "userDashboard"])->name("user-dashboard");
});