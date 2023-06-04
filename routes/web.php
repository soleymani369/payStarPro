<?php

use App\Helpers\PayStar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserCommodityController;
use App\Http\Controllers\Commodity\CommodityController;
use App\Http\Controllers\Admin\AdminCommodityController;

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

Auth::routes();

//route for pick up item

Route::prefix('/home')->group(function () {
    Route::get('/store', [CommodityController::class , 'index'])->name('home.commodity.index');
    Route::get('/store/{commodity}/show', [CommodityController::class , 'show'])->name('home.commodity.show');
});

// route for user order


Route::prefix('/home')->group(function () {
    Route::get('/orderList', [UserCommodityController::class , 'orderList'])->name('user.commodity.orderList');
    Route::get('/checkout', [UserCommodityController::class, 'checkout'])->name('user.commodity.checkout');
    Route::post('/orderResult', [UserCommodityController::class, 'orderResult'])->name('user.commodity.orderResualt');
    Route::post('/{commodity}/addItemToOrder', [UserCommodityController::class , 'addItemToOrder'])->name('user.commodity.addItemToOrder');
    Route::post('/{commodity}/removeItemFromOrder', [UserCommodityController::class , 'removeItemFromOrder'])->name('user.commodity.removeItemFromOrder');
    Route::get('/checkoutList/{order}', [UserCommodityController::class , 'checkoutList'])->name('user.commodity.checkoutList');
    Route::get('/home/order/pay/{order}', [UserCommodityController::class,'payOrder'])->name('user.commodity.pay');
});




//admin commodity routes

Route::group(['prefix' => '/admin/commodity'], function () {
    Route::get('/index', [AdminCommodityController::class,'index'])->name('admin.commodity.index');
    Route::get('/create', [AdminCommodityController::class,'create'])->name('admin.commodity.create');
    Route::post('', [AdminCommodityController::class,'store'])->name('admin.commodity.store');
    Route::get('{commodity}/show', [AdminCommodityController::class,'show'])->name('admin.commodity.show');
    Route::get('/{commodity}/edit', [AdminCommodityController::class,'edit'])->name('admin.commodity.edit');
    Route::post('/{commodity}', [AdminCommodityController::class,'update'])->name('admin.commodity.update');
    Route::get('/{commodity}', [AdminCommodityController::class,'destroy'])->name('admin.commodity.delete');
});
