<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'contact', 'namespace' => 'Contact'], function () {
    Route::get('/', [Api\ApiContactController::class, 'index'])->name("api.contact.index");
    Route::get('/add', [Api\ApiContactController::class, 'add'])->name("api.contact.add");
    Route::post('/store', [Api\ApiContactController::class, 'store'])->name("api.contact.store");
    Route::get('/edit/{id}', [Api\ApiContactController::class, 'edit'])->name("api.contact.edit");
    Route::post('/update/{id}', [Api\ApiContactController::class, 'update'])->name("api.contact.update");
    Route::get('/delete/{id}', [Api\ApiContactController::class, 'delete'])->name("api.contact.delete");
});


Route::get('/showFormAPiNam', [Api\ApiContactController::class, 'showFormAPiNam'])->name("admin.contact.showFormAPiNam");
Route::post('/callApiNam', [Api\ApiContactController::class, 'callApiNam'])->name("api.contact.callApiNam");

Route::group(['prefix' => 'api-call', 'namespace' => 'APiCall', 'middleware' => 'web'], function () {
    Route::get('/', [Api\ApiUserController::class, 'index'])->name("api.users.index");
    Route::get('/add', [Api\ApiUserController::class, 'add'])->name("api.users.add");
    Route::post('/store', [Api\ApiUserController::class, 'store'])->name("api.users.store");
    Route::get('/edit/{id}', [Api\ApiUserController::class, 'edit'])->name("api.users.edit");
    Route::post('/update/{id}', [Api\ApiUserController::class, 'update'])->name("api.users.update");
    Route::get('/delete/{id}', [Api\ApiUserController::class, 'delete'])->name("api.users.delete");
});
