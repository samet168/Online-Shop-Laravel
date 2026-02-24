<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;



//user Router
Route::get('/user',[UserController::class,'index'])->name('user.index');
Route::get('/user/list',[UserController::class,'list'])->name('user.list');
Route::Post('/user/store',[UserController::class,'store'])->name('user.store');
Route::Post('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::Post('/user/update/{id}',[UserController::class,'update'])->name('user.update');
Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');


//category Router
Route::get('/category',[CategoryController::class,'index'])->name('category.index');
Route::get('/category/list',[CategoryController::class,'list'])->name('category.list');
Route::Post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::Post('/category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
Route::Post('/category/update/{id}',[CategoryController::class,'update'])->name('category.update');
Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::post('/category/upload', [CategoryController::class, 'upload'])->name('category.upload');
Route::post('/category/cancel', [CategoryController::class, 'cancel'])->name('category.cancel');