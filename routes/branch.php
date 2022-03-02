<?php
use Illuminate\Support\Facades\Route;

// Routes with Prefix admin/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;

Route::group(['middleware'=>['auth:admin', 'verify_role:branch_admin'], 'as' => 'admin.cfa.'], function() {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('get_chart_data', [DashboardController::class, 'getDataForChart'])->name('chart_data');

    Route::get('orders/getlist', [OrderController::class, 'getList'])->name('orders.getlist');
    Route::get('orders/index', [OrderController::class, 'index'])->name('orders.index');
    Route::post('orders/update_status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
    Route::get('orders/show/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('products/stock', [OrderController::class, 'productstock'])->name('productstock');

    //Route::resource('products', ProductController::class);
    Route::get('products/getLists', [OrderController::class, 'getLists'])->name('products.getLists');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');

    Route::get('export/cfa/product-details', [UserController::class, 'product_export'])->name('product_export_cfa');


});
