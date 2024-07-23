<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontEndController;
use App\Http\Controllers\Frontend\BlogFrontEndController;
use App\Http\Controllers\Frontend\EnquiryFrontEndController;
use App\Http\Controllers\Frontend\WorkSheetFrontEndController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\WishlistController;
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

// Login & Register
Route::get('/login',[AuthController::class,'login']);
Route::get('/register',[AuthController::class,'register']);
Route::post('/user-register',[AuthController::class,'userRegister']);
Route::post('/user-login',[AuthController::class,'userLogin']);
Route::get('/logout',[AuthController::class,'userLogout']);
// Route::post('/verification',[AuthController::class,'verifyUser']);
// Route::get('/verification',[AuthController::class,'userLogout']);
Route::post('/registration-completed',[AuthController::class,'regCompleted']);

// Normal Pages
Route::get('/',[FrontEndController::class,'index']);
Route::get('/about-us',[FrontEndController::class,'aboutUs']);
Route::post('/serach-worksheet',[FrontEndController::class,'searchIndex']);
Route::get('/serach-worksheet',[WorkSheetFrontEndController::class,'index']);
Route::get('/blog',[BlogFrontEndController::class,'viewblog']);
Route::get('/blog-details/{id}',[BlogFrontEndController::class,'viewBlogDetails']);
Route::get('/blog/{id}',[BlogFrontEndController::class,'categoryBlogs']);
Route::get('pages/{slug}',[FrontEndController::class,'dynamicPage']);
Route::get('/faq',[FrontEndController::class,'faqShow']);
Route::get('/contact',[EnquiryFrontEndController::class,'contactUs']);
Route::post('/submit-enquiry',[EnquiryFrontEndController::class,'submitEnq']);
Route::get('/worksheet',[WorkSheetFrontEndController::class,'index']);
Route::get('/worksheet-details/{id}',[WorkSheetFrontEndController::class,'worksheetDetails']);
Route::get('/worksheet/{id}',[WorkSheetFrontEndController::class,'worksheetFilter']);
Route::post('/filter-worksheet',[WorkSheetFrontEndController::class,'filterWorksheet']);

Route::get('/product-listing',[WorkSheetFrontEndController::class,'newProduct']);
Route::get('/product-details',[WorkSheetFrontEndController::class,'productDetails']);

// Set Cookies For Cart
Route::post('/add-cart',[CartController::class,'setcartCookie']);
Route::post('/view-cart',[CartController::class,'updatecart']);
Route::get('/cart',[CartController::class,'viewcart']);
Route::get('/remove-product/{id}',[CartController::class,'removeCartItem']);

// Login user Page
Route::get('/checkout',[CheckoutController::class,'index']);
Route::post('/fetch-city',[CheckoutController::class,'fetchCity']);
Route::post('/apply-coupon-code',[CheckoutController::class,'applyCouponCode']);
Route::post('/calculate-total-amount',[CheckoutController::class,'calculatetotalAmount']);
Route::post('/submit-payment',[CheckoutController::class,'storePaymentDetails']);
Route::get('/order-invoice/{id}',[UserController::class,'orderInvoice']);
Route::get('/give-review/{id}',[UserController::class,'giveReview']);
Route::post('/submit-review',[UserController::class,'submitReview']);
Route::post('/add-wishlist',[WishlistController::class,'addWishlist']);
Route::get('/wishlist',[WishlistController::class,'viewWishlist']);
Route::get('/remove-wishlist/{id}',[WishlistController::class,'removeWishlist']);
Route::post('/view-wishlist',[WishlistController::class,'updateWishlist']);
Route::get('/payment-sucess',[CheckoutController::class,'razorpaySuccessPayment']);
Route::get('/razor-pay-payment-failed',[CheckoutController::class,'razorpayFailedPayment']);
// Myaccount
Route::get('/my-profile',[UserController::class,'userProfile']);
Route::post('/update-profile',[UserController::class,'updateProfile']);
Route::get('/order-history',[UserController::class,'orderHistory']);
Route::get('/change-password',[UserController::class,'changePassword']);
Route::post('/update-password',[UserController::class,'updatepassword']);

Route::group(['middleware'=>['auth']],function(){
    Route::get('/download-digital-file',[CheckoutController::class,'downloadDigitalFile']);
});

Route::get('/404', function () {
    abort(404);
});