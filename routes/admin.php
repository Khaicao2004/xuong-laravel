<?php
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
->as('admin.')
->group(function () {
    Route::get('/', function (){
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('catalogues', CatalogueController::class);
    Route::resource('products',ProductController::class);
    Route::resource('productcolors',ProductColorController::class);
    Route::resource('productsizes',ProductSizeController::class);
    Route::resource('users',UserController::class);
    Route::resource('orders',OrderController::class);
});
