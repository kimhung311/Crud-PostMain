<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ColllertionController;
use App\Http\Controllers\FileStorageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


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
// Route::get('/', [CategoryController::class, 'index'])->name('index');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(['middleware' => ['check_login'], 'as' => 'auth.login'], function () {
    Route::group(['prefix' => 'category',  'as' => 'category.'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'], function (Request $request) {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|unique:categories|max:255',
                'thumbnail' => 'required',
            ]);
            if ($validator->fails()) {
                // validate fails
            }
        })->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('/test-helper', [CategoryController::class, 'checkHelper'])->name('checkHelper');
        Route::get('/test', [CategoryController::class, 'test'])->name('test');

    });



    Route::group(['prefix' => 'product',  'as' => 'product.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');

    });

    Route::group(['prefix' => 'collect',  'as' => 'collect.'], function () {
        Route::get('/', [ColllertionController::class, 'index'])->name('index');
        Route::get('/filter', [ColllertionController::class, 'filter'])->name('filter');
        Route::get('/first', [ColllertionController::class, 'first'])->name('first');
        Route::get('/getUsers', [ColllertionController::class, 'getUsers'])->name('getUsers');
        Route::get('/where', [ColllertionController::class, 'where'])->name('where');
        Route::get('/filter', [ColllertionController::class, 'filter'])->name('filter');
        Route::get('/groupBy', [ColllertionController::class, 'groupBy'])->name('groupBy');
        Route::get('/chunkMe', [ColllertionController::class, 'chunkMe'])->name('chunkMe');
    });
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

        return view('dashboard');
    })->name('dashboard');
    Route::group(['prefix' => 'collection',  'as' => 'collection.'], function () {
        Route::get('/', [ColllertionController::class, 'index'])->name('index');
    });
});