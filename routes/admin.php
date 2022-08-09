
<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', [Admin\AdminHomeController::class, 'index'])->name("admin.index");

    Route::group(['prefix' => 'category', 'namespace' => 'Category'], function () {
        Route::get('/', [Admin\AdminCategoryController::class, 'index'])->name("admin.category.index");
        Route::get('/add', [Admin\AdminCategoryController::class, 'add'])->name("admin.category.add");
        Route::post('/store', [Admin\AdminCategoryController::class, 'store'])->name("admin.category.store");
        Route::get('/edit/{id}', [Admin\AdminCategoryController::class, 'edit'])->name("admin.category.edit");
        Route::post('/update/{id}', [Admin\AdminCategoryController::class, 'update'])->name("admin.category.update");
        Route::post('/delete/{id}', [Admin\AdminCategoryController::class, 'delete'])->name("admin.category.delete");

        Route::post('/load-active/{id}', [Admin\AdminCategoryController::class, 'loadActive'])->name("admin.category.load.active");

    });

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('/', [Admin\AdminUserController::class, 'index'])->name("admin.user.index");
        Route::get('/add', [Admin\AdminUserController::class, 'add'])->name("admin.user.add");
        Route::post('/store', [Admin\AdminUserController::class, 'store'])->name("admin.user.store");
        Route::get('/edit/{id}', [Admin\AdminUserController::class, 'edit'])->name("admin.user.edit");
        Route::post('/update/{id}', [Admin\AdminUserController::class, 'update'])->name("admin.user.update");
        Route::post('/delete/{id}', [Admin\AdminUserController::class, 'delete'])->name("admin.user.delete");

        Route::post('/load-active/{id}', [Admin\AdminUserController::class, 'loadActive'])->name("admin.user.load.active");

    });

});

