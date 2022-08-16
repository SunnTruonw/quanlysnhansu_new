
<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Ajax;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;

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



//Login, Logout
Route::get('admin/login', [Auth\AdminLoginController::class, 'showLoginForm'])->name("admin.login");
Route::get('admin/logout', [Auth\AdminLoginController::class, 'logout'])->name("admin.logout");
Route::post('admin/loginSubmit', [Auth\AdminLoginController::class, 'login'])->name("admin.login.submit");

//Active user
Route::get('admin/active-user', [Auth\AdminLoginController::class, 'showActiveUserForm'])->name("admin.active-user.index");
Route::get('admin/load-active-user/{id}', [Auth\AdminLoginController::class, 'loadActiveUser'])->name("admin.user.load.role");
Route::post('admin/change-password/{id}', [Auth\AdminLoginController::class, 'changePassword'])->name("admin.changePassword.update");
Route::get('/apiBieuDo', [Admin\AdminHomeController::class, 'apiBieuDo'])->name("admin.apiBieuDo");
<<<<<<< HEAD
Route::get('/user-rooms', [Admin\AdminHomeController::class, 'userRooms'])->name("admin.userRooms");

=======
>>>>>>> b95510ecd4b2df74459265c0329df7357b542a63


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

    // Route::group(['prefix' => 'account', 'namespace' => 'Account'], function () {
    //     Route::get('/edit/{id}', [Admin\AdminAccountController::class, 'edit'])->name("admin.account.edit");
    //     Route::post('/update/{id}', [Admin\AdminAccountController::class, 'update'])->name("admin.account.update");
    //     Route::post('/delete/{id}', [Admin\AdminAccountController::class, 'delete'])->name("admin.account.delete");
    // });

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('/', [Admin\AdminUserController::class, 'index'])->name("admin.user.index");
        Route::get('/add', [Admin\AdminUserController::class, 'add'])->name("admin.user.add");
        Route::post('/store', [Admin\AdminUserController::class, 'store'])->name("admin.user.store");
        Route::get('/edit/{id}', [Admin\AdminUserController::class, 'edit'])->name("admin.user.edit");
        Route::post('/update/{id}', [Admin\AdminUserController::class, 'update'])->name("admin.user.update");
        Route::get('/delete/{id}', [Admin\AdminUserController::class, 'delete'])->name("admin.user.delete");
        Route::get('/load-active/{id}', [Admin\AdminUserController::class, 'loadActive'])->name("admin.user.load.active");


        Route::get('/detail/{id}', [Admin\AdminUserController::class, 'detail'])->name("admin.user.detail");
        Route::get('/calendar/{id}', [Admin\AdminUserController::class, 'loadCalendar'])->name("admin.user.calendar");
        Route::get('/load-calendar/{id}', [Admin\AdminUserController::class, 'loadActiveCalendar'])->name("admin.user.load.calendar");
    });

    Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
        Route::group(['prefix' => 'address'], function () {
            Route::get('district', [Ajax\AddressController::class, 'getDistricts'])->name('ajax.address.districts');
        });
    });

    Route::group(['prefix' => 'room', 'namespace' => 'Room'], function () {
        Route::get('/', [Admin\AdminRoomController::class, 'index'])->name("admin.room.index");
        Route::get('/add', [Admin\AdminRoomController::class, 'add'])->name("admin.room.add");
        Route::post('/store', [Admin\AdminRoomController::class, 'store'])->name("admin.room.store");
        Route::get('/edit/{id}', [Admin\AdminRoomController::class, 'edit'])->name("admin.room.edit");
        Route::post('/update/{id}', [Admin\AdminRoomController::class, 'update'])->name("admin.room.update");
        Route::get('/delete/{id}', [Admin\AdminRoomController::class, 'delete'])->name("admin.room.delete");

        Route::get('/load-active/{id}', [Admin\AdminRoomController::class, 'loadActive'])->name("admin.room.load.active");

    });

});

