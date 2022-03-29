<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\BlogController;
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
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Recpie;
use App\Http\Controllers\Admin\SubscriptionController;

Route::redirect('/', 'dashboard');

Route::get('login', [LoginController::class, 'index'])->name('admin.login');

Route::post('login', [LoginController::class, 'login'])->name('admin.auth');
Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::group(['middleware'=>['auth:admin', 'verify_role:admin'], 'as' => 'admin.'], function() {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('get_chart_data', [DashboardController::class, 'getDataForChart'])->name('chart_data');

    Route::get('recipes/category/list', [RecipeController::class, 'category_index'])->name('recipes_category_list');
    Route::get('recipes/category/getlist', [RecipeController::class, 'categorygetlist'])->name('recipe.categories.getlist');
    Route::get('recipes/category/create', [RecipeController::class, 'category_create'])->name('recipe.categories.create');
    Route::post('recipes/category/store', [RecipeController::class, 'category_store'])->name('recipe.categories_store');
    Route::get('recipes/category/edit/{id}', [RecipeController::class, 'category_edit'])->name('recipe.category_edit');
    Route::post('recipes/category/update/{id}', [RecipeController::class, 'category_update'])->name('recipe.categories_update');
    Route::get('recipes/category/delete/{id}', [RecipeController::class, 'category_delete'])->name('recipe.categories_delete');


    Route::get('recipes/list', [RecipeController::class, 'recipe_index'])->name('recipes_list');
    Route::get('recipes/getlist', [RecipeController::class, 'recipegetlist'])->name('recipe.getlist');
    Route::get('recipes/create', [RecipeController::class, 'recipe_create'])->name('recipe.create');
    Route::post('recipes/store', [RecipeController::class, 'recipe_store'])->name('recipe.store');
    Route::get('recipes/edit/{id}', [RecipeController::class, 'recipe_edit'])->name('recipe.recipe_edit');
    Route::post('recipes/update/{id}', [RecipeController::class, 'recipe_update'])->name('recipe.recipe_update');
    Route::get('recipes/delete/{id}', [RecipeController::class, 'recipe_delete'])->name('recipe.recipe_delete');

    Route::get('subscription/list', [SubscriptionController::class, 'index'])->name('subscription');
    Route::get('subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('subscription/store', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('subscription/edit/{id}', [SubscriptionController::class, 'edit'])->name('subscription.edit');
    Route::post('subscription/update/{id}', [SubscriptionController::class, 'update'])->name('subscription.update');
    Route::get('subscription/delete/{id}', [SubscriptionController::class, 'delete'])->name('subscription.delete');
    Route::post('subscription/get_category_wise_products', [SubscriptionController::class, 'get_category_wise_products'])->name('get_category_wise_products');
    Route::post('subscription/get_products_packs', [SubscriptionController::class, 'get_products_packs'])->name('get_products_packs');

    Route::get('user/subscription/list', [SubscriptionController::class, 'users_index'])->name('subscription.user');
    Route::get('user/subscription/delete/{id}', [SubscriptionController::class, 'users_delete'])->name('subscription.delete.user');
    Route::post('user/subscription/change_sub_status', [SubscriptionController::class, 'user_change_sub_status'])->name('user_change_sub_status');
    Route::get('user/subscription/order/list/{id}', [SubscriptionController::class, 'users_orders'])->name('subscription.user.orders');

    Route::get('blog/list', [BlogController::class, 'index'])->name('blog.list');
    Route::get('blog/getlist', [BlogController::class, 'getlist'])->name('blog.getlist');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::get('blog/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');

    Route::get('admin-user/list', [AdminUserController::class, 'index'])->name('admin-user.list');
    Route::get('admin-user/getlist', [AdminUserController::class, 'getlist'])->name('admin-user.getlist');
    Route::get('admin-user/create', [AdminUserController::class, 'create'])->name('admin-user.create');
    Route::post('admin-user/store', [AdminUserController::class, 'store'])->name('admin-user.store');
    Route::get('admin-user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin-user.edit');
    Route::post('admin-user/update/{id}', [AdminUserController::class, 'update'])->name('admin-user.update');
    Route::get('admin-user/delete/{id}', [AdminUserController::class, 'delete'])->name('admin-user.delete');
    Route::post('admin-user/change-status', [AdminUserController::class, 'change_status'])->name('admin-user.change-status');

    // Category //
    Route::get('categories/getlist', [CategoryController::class, 'getList'])->name('categories.getlist');
    Route::post('categories/faq/update', [CategoryController::class, 'updateFaq'])->name('categories.faq.update');
    Route::get('categories/faq/delete/{faq_id}', [CategoryController::class, 'deleteFaq'])->name('categories.faq.delete');
    Route::resource('categories', CategoryController::class);

    // Product //
    Route::get('products/getlist', [ProductController::class, 'getList'])->name('products.getlist');
    Route::resource('products', ProductController::class);

    // Branch //
    Route::get('branches/getlist', [BranchController::class, 'getList'])->name('branches.getlist');
    Route::resource('branches', BranchController::class);

    // Coupon //
    Route::resource('coupons', CouponController::class);

        //Review
        Route::get('reviewReport',[UserController::class,'reviewReport'])->name('reviewReport');
        Route::post('reviewReplyAdd',[UserController::class,'reviewReplyAdd'])->name('reviewReplyAdd');
        Route::post('reviewStatusupdate',[UserController::class,'reviewStatusupdate'])->name('reviewStatusupdate');
        Route::get('review/delete', [UserController::class, 'review_delete'])->name('review_delete');
        Route::get('reply/delete', [UserController::class, 'delete_reply'])->name('delete_reply');


    // Inventory //
    Route::get('branches/inventory/{branch}', [InventoryController::class, 'index'])->name('branches.inventory.index');
    Route::get('branches/inventory/getlist/{branch}', [InventoryController::class, 'getInventroyList'])->name('branches.inventory.getlist');
    Route::post('branches/inventory/update/quantity', [InventoryController::class, 'updateQuantity'])->name('branches.inventory.updatequantity');
    Route::get('branches/inventory/export/template/{branch_id}', [InventoryController::class, 'exportTemplateForInventory'])->name('branches.inventory.export_template');
    Route::get('branches/inventory/import/stock/{branch_id}', [InventoryController::class, 'importStockView'])->name('branches.inventory.import_view');
    Route::post('branches/inventory/import/stock', [InventoryController::class, 'importStock'])->name('branches.inventory.import');

    // Order //
    Route::get('orders/getlist', [OrderController::class, 'getList'])->name('orders.getlist');
    Route::get('orders/getlistByFilter', [OrderController::class, 'getlistByFilter'])->name('orders.getlistByFilter');
    Route::get('orders/index', [OrderController::class, 'index'])->name('orders.index');
    Route::post('orders/update_status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
    Route::get('orders/show/{order}', [OrderController::class, 'show'])->name('orders.show');

    // User //
    Route::get('users/getlist', [UserController::class, 'getList'])->name('users.getlist');
    Route::resource('users', UserController::class)->only('index', 'show', 'update');

        //customer
        Route::get('customers', [UserController::class, 'customers'])->name('customers');
        Route::post('updateCustomer', [UserController::class, 'updateCustomer'])->name('updateCustomer');
        Route::get('customer/{id}/allorder', [UserController::class, 'allcustOrder'])->name('customer.allorder');
        Route::get('customer/{id}/delete', [UserController::class, 'delete_customer'])->name('customer.delete');
        Route::post('customer/filter', [UserController::class, 'allcustOrderfilter'])->name('customer.filter');
        Route::get('Transactional', [UserController::class, 'Transactional'])->name('Transactional');
        Route::get('productstock', [UserController::class, 'productstock'])->name('productstock');

        Route::get('export/product-details', [UserController::class, 'product_export'])->name('product_export');

        //pages
        Route::get('about-us', [SettingController::class, 'about_us'])->name('about-us');
        Route::post('about-us/save', [SettingController::class, 'about_us_store'])->name('settings.about_us.store');
        Route::post('about-us2/save', [SettingController::class, 'about_us2_store'])->name('settings.about_us2.store');
        Route::get('about-us/delete', [SettingController::class, 'about_us_delete'])->name('settings.about_us.delete');
        Route::get('about-us2/delete', [SettingController::class, 'about_us2_delete'])->name('settings.about_us2.delete');
        Route::post('about-us3/save', [SettingController::class, 'about_us3_store'])->name('settings.about_us3.store');
        Route::post('about-us4/save', [SettingController::class, 'about_us4_store'])->name('settings.about_us4.store');
        Route::get('about-us4/delete', [SettingController::class, 'about_us4_delete'])->name('settings.about_us4.delete');
        Route::post('about-us5/save', [SettingController::class, 'about_us5_store'])->name('settings.about_us5.store');
        Route::get('about-us5/delete', [SettingController::class, 'about_us5_delete'])->name('settings.about_us5.delete');

        //pages part
        Route::get('pages', [SettingController::class, 'pages_show'])->name('pages_show');
        Route::get('page/create', [SettingController::class, 'page_create'])->name('page_create');
        Route::post('page/store', [SettingController::class, 'page_store'])->name('page_store');
        Route::get('page/edit', [SettingController::class, 'page_edit'])->name('page_edit');
        Route::post('page/update', [SettingController::class, 'page_update'])->name('page_update');
        Route::get('page/delete', [SettingController::class, 'page_delete'])->name('page_delete');
        Route::post('page/page_change_status', [SettingController::class, 'page_change_status'])->name('page_change_status');

        //image library
        Route::get('image-library', [SettingController::class, 'image_library'])->name('image_library');
        Route::post('image-library/store', [SettingController::class, 'image_library_store'])->name('image_library_store');
        Route::get('image-library/delete', [SettingController::class, 'image_library_delete'])->name('image_library_delete');

        //email subs

        Route::get('user/email-susbcription', [UserController::class, 'get_all_sub_users_email'])->name('user.subs');
        Route::get('email-sub/delete/{id}', [UserController::class, 'delete_sub'])->name('email_sub.delete');



        // Setting //
    Route::group(['as' => 'settings.', 'prefix' => 'settings'], function() {
        // Banner //
        Route::get('banner/index', [SettingController::class, 'bannerIndex'])->name('banner.index');
        Route::post('banner/store', [SettingController::class, 'bannerStore'])->name('banner.store');
        Route::post('banner/seq/store', [SettingController::class, 'bannerSeqStore'])->name('banner.seq.store');
        Route::get('banner/delete/{banner}', [SettingController::class, 'bannerDelete'])->name('banner.delete');

        // Testimonials //
        Route::resource('testimonials', TestimonialController::class);

    });

});


// Route::group(['middleware'=>['auth:admin'],'as' => 'admin.cfa.', 'prefix' => 'cfa'], function() {
//     Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
// });

Route::get('clear_cache', function () {

    \Artisan::call('cache:clear');
    \Artisan::call('config:cache');
    \Artisan::call('route:cache');

    dd("Cache is cleared");

});
