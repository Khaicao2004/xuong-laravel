<?php

use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Middleware\CheckAdminMiddleware;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[ProductController::class, 'index'])->name('index');
Route::get('/admin',function(){
    return 'Day la admin';
})->middleware('isAdmin');
//home
Route::get('about',[HomeController::class, 'about'])->name('about');



// Auth::routes();
Route::get('auth/login',    [LoginController::class,'showFormLogin'])->name('login');
Route::post('auth/login',   [LoginController::class,'login']);

Route::post('auth/logout',  [LoginController::class,'logout'])->name('logout');

Route::get('auth/register',    [RegisterController::class,'showFormRegister'])->name('register');
Route::post('auth/register',   [RegisterController::class,'register']);

// Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('product/{slug}', [ProductController::class, 'detail'])->name('product.detail');


//mua bán hàng

Route::get('cart/list', [CartController::class, 'list'])->name('cart.list');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('order/save', [OrderController::class, 'save'])->name('order.save');

//shop
Route::get('shop/{id?}',[ShopController::class, 'shop'])->name('shop');
Route::post('filter',[ShopController::class, 'filter'])->name('filter');



    
    
    
    
    
    
    
    
    
    





    
    
    
    