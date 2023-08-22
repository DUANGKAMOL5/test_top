<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Imagecontroller;
use App\Http\Controllers\CatalogController;

use App\Models\Catalog;
use App\Models\Image;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/catalog/all', [CatalogController::class,'index'])->name('catalog');
    Route::post('/catalog/add', [CatalogController::class, 'store'])->name('addCatalog');
    Route::get('/catalog/edit/{id}', [CatalogController::class, 'edit']);
    Route::post('/catalog/update/{id}', [CatalogController::class, 'update'])->name('catalog.update');
    Route::get('/catalog/delete/{id}', [CatalogController::class, 'delete']);
    Route::get('/catalog/{id}', [CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/image/all', [ImageController::class,'index'])->name('image');
    Route::post('/image/add', [ImageController::class, 'store'])->name('addimage');
    Route::get('/image/edit/{id}', [ImageController::class, 'edit']);
    Route::post('/image/update/{id}', [ImageController::class, 'update'])->name('image.update');
    Route::get('/image/delete/{id}', [ImageController::class, 'delete']);
    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs');
    Route::get('/catalogs/{id}', [CatalogController::class, 'show'])->name('catalogs.show');
});
});

