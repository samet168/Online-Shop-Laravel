<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ImageController;
use App\Http\Controllers\Dashboard\ProductController; 
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\DashboardMiddleware;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;



//Login Router

Route::group(['prefix' => 'admin'], function () {
    Route::get('/',[AuthController::class,'login'])->name('auth.index');
    Route::post('/login',[AuthController::class,'authenticate'])->name('auth.authenticate');

    Route::middleware(AuthMiddleware::class)->group(function () {


    
        Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');

        Route::middleware(DashboardMiddleware::class)->group(function () {
            Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.index');
                    //user Router
            Route::get('/user',[UserController::class,'index'])->name('user.index');
            Route::get('/user/list',[UserController::class,'list'])->name('user.list');
            Route::Post('/user/store',[UserController::class,'store'])->name('user.store');
            Route::Post('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
            Route::Post('/user/update/{id}',[UserController::class,'update'])->name('user.update');
            Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        });
        



        //category Router
        Route::get('/category',[CategoryController::class,'index'])->name('category.index');
        Route::get('/category/list',[CategoryController::class,'list'])->name('category.list');
        Route::Post('/category/store',[CategoryController::class,'store'])->name('category.store');
        Route::Post('/category/edit',[CategoryController::class,'edit'])->name('category.edit');
        Route::Post('/category/update',[CategoryController::class,'update'])->name('category.update');
        Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::post('/category/upload', [CategoryController::class, 'upload'])->name('category.upload');
        Route::post('/category/cancel', [CategoryController::class, 'cancel'])->name('category.cancel');


        //Brand Router
        Route::get('/brand',[BrandController::class,'index'])->name('brand.index');
        Route::get('/brand/list',[BrandController::class,'list'])->name('brand.list');
        Route::Post('/brand/store',[BrandController::class,'store'])->name('brand.store');
        Route::Post('/brand/edit',[BrandController::class,'edit'])->name('brand.edit');
        Route::Post('/brand/update',[BrandController::class,'update'])->name('brand.update');
        Route::delete('/brand/destroy/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');



        //color Router
        Route::get('/color',[ColorController::class,'index'])->name('color.index');
        Route::get('/color/list',[ColorController::class,'list'])->name('color.list');
        Route::Post('/color/store',[ColorController::class,'store'])->name('color.store');
        Route::Post('/color/edit',[ColorController::class,'edit'])->name('color.edit');
        Route::Post('/color/update',[ColorController::class,'update'])->name('color.update');
        Route::delete('/color/destroy/{id}', [ColorController::class, 'destroy'])->name('color.destroy');


        //Product Routers
        Route::get("/product",[ProductController::class,'index'])->name("product.index");
        Route::post("/product/list",[ProductController::class,'list'])->name("product.list");
        Route::post("/product/store",[ProductController::class,'store'])->name("product.store");
        Route::post('/product/data',[ProductController::class,'data'])->name('product.data');
        Route::post("/product/edit",[ProductController::class,'edit'])->name("product.edit");
        Route::post("/product/update",[ProductController::class,'update'])->name("product.update");
        Route::post("/product/destroy",[ProductController::class,'destroy'])->name("product.destroy");

        //product imag
        Route::post('/product/upload',[ImageController::class,'uploads'])->name('product.uploads');
        Route::post('/product/cancel',[ImageController::class,'cancel'])->name('product.cancel');
    });


});

