<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminItemController;
use App\Http\Controllers\AdminLocationController;
use App\Http\Controllers\AdminMediaTypeController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')
    // ->middleware('auth')
    ->group(function () {
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/categories', [AdminCategoryController::class, 'store']);
        Route::get('/categories/{category}', [AdminCategoryController::class, 'show'])->name('admin.category.show');
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update']);
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy']);

        Route::get('/locations', [AdminLocationController::class, 'index'])->name('admin.location.index');
        Route::get('/locations/create', [AdminLocationController::class, 'create'])->name('admin.location.create');
        Route::post('/locations', [AdminLocationController::class, 'store']);
        Route::get('/locations/{location}', [AdminLocationController::class, 'show'])->name('admin.location.show');
        Route::get('/locations/{location}/edit', [AdminLocationController::class, 'edit'])->name('admin.location.edit');
        Route::put('/locations/{location}', [AdminLocationController::class, 'update']);
        Route::delete('/locations/{location}', [AdminLocationController::class, 'destroy']);

        Route::get('/media-types', [AdminMediaTypeController::class, 'index'])->name('admin.media-type.index');
        Route::get('/media-types/create', [AdminMediaTypeController::class, 'create'])->name('admin.media-type.create');
        Route::post('/media-types', [AdminMediaTypeController::class, 'store']);
        Route::get('/media-types/{mediaType}', [AdminMediaTypeController::class, 'show'])->name('admin.media-type.show');
        Route::get('/media-types/{mediaType}/edit', [AdminMediaTypeController::class, 'edit'])->name('admin.media-type.edit');
        Route::put('/media-types/{mediaType}', [AdminMediaTypeController::class, 'update']);
        Route::delete('/media-types/{mediaType}', [AdminMediaTypeController::class, 'destroy']);

        Route::get('/items', [AdminItemController::class, 'index'])->name('admin.item.index');
        Route::get('/items/create', [AdminItemController::class, 'create'])->name('admin.item.create');
        Route::post('/items', [AdminItemController::class, 'store']);
        Route::get('/items/{item}', [AdminItemController::class, 'show'])->name('admin.item.show');
        Route::get('/items/{item}/edit', [AdminItemController::class, 'edit'])->name('admin.item.edit');
        Route::put('/items/{item}', [AdminItemController::class, 'update']);
        Route::delete('/items/{item}', [AdminItemController::class, 'destroy']);
    });

Route::get('/', [ItemController::class, 'index'])->name('items.index');
