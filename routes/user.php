<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Front\CatalogController;

use App\Http\Controllers\Front\CheckoutController;

use App\Http\Controllers\Front\TestController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\RazorpayController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\TrackOrderController;
use App\Http\Controllers\Front\SubscriptionController;
use Darryldecode\Cart\CartCondition;

Route::get('/', [HomeController::class, 'index'])->name('front.index');
Route::get('/home', [HomeController::class, 'index']);
// Route::get('/blog',[HomeController::class, 'blog'])->name('front.blog');
Route::get('/blogs',[HomeController::class, 'blog'])->name('front.blog');
Route::get('/blog/{slug}',[HomeController::class, 'blog_details'])->name('front.blog_details');

Route::get('/recipes/{slug?}',[HomeController::class, 'recipes'])->name('front.recipes');
Route::get('/recipe/{recipe}',[HomeController::class, 'recipeShow'])->name('front.recipe.show');
Route::get('/aboutus',[HomeController::class, 'aboutus'])->name('front.aboutus');
Route::get('/contactus',[HomeController::class, 'contactus'])->name('front.contactus');
Route::get('/products',[HomeController::class, 'products'])->name('front.products');


Route::get('/terms-conditions', [HomeController::class, 'terms'])->name('front.terms');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('front.privacy_policy');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('front.refund_policy');

Route::post('/pincode/store',[HomeController::class, 'storePincode'])->name('front.savepincode');
Route::get('/pincode/declined',[HomeController::class, 'pincodeDeclined'])->name('front.pincodedeclined');

Route::get('/get_cities_by_state',[HomeController::class, 'getCitiesByState'])->name('front.get_cities_by_state');
Route::post('/reviewAdd',[RegisterController::class, 'reviewAdd'])->name('reviewAdd');


Route::get('/get_price_and_pack', [HomeController::class, 'getPriceForProductPack'])->name('front.getprodcutprice');

// CART SECTION
Route::get('/cart',[CartController::class, 'cartpage'])->name('cart.page');
Route::get('/cart/changeqty/{unique_id}',[CartController::class, 'changeQuantity'])->name('product.cart.changeQuantity');
Route::get('/carts/view',[CartController::class, 'cartview']);
Route::get('/addcart/{id}/{packId}',[CartController::class, 'addcart'])->name('product.cart.add');
Route::get('/removecart/{id}',[CartController::class, 'removecart'])->name('product.cart.remove');
Route::get('/carts',[CartController::class, 'cart'])->name('front.cart');
Route::post('/redeem/coupon', [CartController::class, 'redeemCoupon'])->name('front.redeem_coupon');

// CHECKOUT SECTION
Route::get('/checkout',[CheckoutController::class, 'checkout'])->name('front.checkout');


Route::get('/thankyou', [PaymentController::class, 'payreturn'])->name('payment.return');
Route::get('/checkout/payment/cancle', 'Front\PaymentController@paycancle')->name('payment.cancle');

// CONTACT
Route::post('/contact_us', [HomeController::class, 'contactInfoSave'])->name('contact_us.submit');

// EMAIL SUBSCRIPTION
Route::post('/subscribe/email', [HomeController::class, 'subscribeToEmail'])->name('subscribe.email');

// TEST ROUTES
Route::get('/test/add',[TestController::class, 'add']);
Route::get('/test/show',[TestController::class, 'show']);
Route::get('/test/remove',[TestController::class, 'remove']);
Route::get('/test/email',[TestController::class, 'testEmail']);
Route::get('/test/instagram',[TestController::class, 'testInstagram']);

// PRODCT SECTION
Route::get('/item/{slug}',[CatalogController::class, 'product'])->name('front.product');


// TRACK ORDER
Route::get('/track/order', [TrackOrderController::class,'index'])->name('front.track.index');
Route::post('/track/order', [TrackOrderController::class,'track'])->name('front.track.order');
Route::post('/order/cancel', [TrackOrderController::class,'cancelOrder'])->name('front.track.order.cancel');

Route::get('/webhook/shipment/update', [TrackOrderController::class, 'webhookUpdate']);

//RazorPay Routes

Route::post('/razorpay-submit', [RazorpayController::class, 'store'])->name('razorpay.submit');
Route::post('/razorpay-callback', [RazorpayController::class, 'razorCallback'])->name('razorpay.notify');

  Route::post('/cashondelivery', [CheckoutController::class, 'cashondelivery'])->name('cash.submit');
  Route::post('/gateway', [CheckoutController::class, 'gateway'])->name('gateway.submit');

 	Route::get('/checkout/payment/{slug1}/{slug2}',[CheckoutController::class, 'loadpayment'])->name('front.load.payment');


Route::prefix('user')->group(function() {

	// User Login
	Route::get('/userlogin', [LoginController::class, 'showLoginForm'])->name('user.userlogin');
	Route::post('/userlogin', [LoginController::class, 'login'])->name('user.userlogin.submit');

	// User Register
  	Route::get('/userregister', [RegisterController::class, 'showRegisterForm'])->name('user.userregister');
  	Route::post('/userregister', [RegisterController::class, 'register'])->name('user-register-submit');

  	// User Dashboard
  	Route::get('/dashboard', [UserController::class, 'index'])->name('user-dashboard');
      //create user packs
    Route::get('/create/pack', [UserController::class, 'create_pack'])->name('create.user-pack');
    Route::post('/save/pack', [UserController::class, 'save_pack'])->name('user.save-user-pack');
	Route::post('/get_category_wise_products', [UserController::class, 'get_category_wise_products'])->name('user.get_category_wise_products');
    // User Logout

    //subscription
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscription');
    Route::post('/subscription/payment', [SubscriptionController::class, 'payment'])->name('subscription.payment');
    Route::post('/subscription/callback', [SubscriptionController::class, 'razorCallback'])->name('subscription.notify');
    Route::get('/subscription/success', [SubscriptionController::class, 'show_msg'])->name('subscription.return');
    Route::post('/cancel/subscription', [SubscriptionController::class, 'cancel_sub'])->name('subscription.cancel');
    Route::get('/subscription/generate_orders', [SubscriptionController::class, 'generate_orders'])->name('subscription.generate_orders'); // cron job
    Route::get('/subscription/delete/unpaid', [SubscriptionController::class, 'delete_unpaid_subscription'])->name('subscription.delete_unpaid_subscription'); // cron job


    Route::get('/subscription/create_payment_links_main', [SubscriptionController::class, 'create_payment_links_main'])->name('subscription.create_payment_links_main');

  	Route::get('/logout', [LoginController::class, 'logout'])->name('user-logout');

});


// CATEGORY SECTION
  Route::get('/{category}',[CatalogController::class, 'category'])->name('front.category');

  //page section
  Route::get('/page/{slug}',[HomeController::class, 'show_page'])->name('front.show_page');

  Route::get('/update_status/{id}',[SubscriptionController::class, 'update_payment_status'])->name('user.update_payment_status');


