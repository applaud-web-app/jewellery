<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\DynamicPagesController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;


Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/admin-auth-check',[LoginController::class,'adminAuthCheck'])->name('admin.auth.check');

Route::middleware('AuthMiddleware')->group(function () {
// Dashboard
Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard');
Route::get('/logout',[LoginController::class,'logout']);
Route::get('/profile',[DashboardController::class,'profileView']);
Route::post('/update-profile',[DashboardController::class,'updateProfile']);
// Customer
Route::get('/customer',[CustomerController::class,'index']);
Route::get('/edit-customer/{id}',[CustomerController::class,'edit_customer']);
Route::post('/update-customer',[CustomerController::class,'update_customer']);
// Reviews
Route::get('/all-reviews',[ReviewController::class,'index']);
Route::get('/create-reviews',[ReviewController::class,'create']);
Route::post('/add-review',[ReviewController::class,'store']);
Route::get('/review-edit/{id}',[ReviewController::class,'edit']);
Route::post('/update-review',[ReviewController::class,'update']);
Route::get('/review-delete/{id}',[ReviewController::class,'destroy']);
Route::get('/update-status/{id}',[ReviewController::class,'changeStatus']);
Route::post('/filter-reviews',[ReviewController::class,'filterReview']);
Route::post('/review-bulk-action',[ReviewController::class,'bulkAction']);
// FAQ
Route::get('/all-faq',[FaqController::class,'allFaq']);
Route::get('/add-faq',[FaqController::class,'addFaq']);
Route::post('/add-faq',[FaqController::class,'insertFaq']);
Route::get('/remove-faq',[FaqController::class,'removeFaq']);
Route::get('/edit-faq',[FaqController::class,'editFaq']);
Route::post('/update-faq',[FaqController::class,'updateFaq']);
Route::get('/search-faq',[FaqController::class,'searchFaq']);
// Dynamic Pages
Route::get('/all-pages',[DynamicPagesController::class,'allPages']);
Route::get('/add-page',[DynamicPagesController::class,'addPages']);
Route::post('/add-page',[DynamicPagesController::class,'insertPage']);
Route::get('/remove-page',[DynamicPagesController::class,'removePage']);
Route::get('/edit-page',[DynamicPagesController::class,'editPage']);
Route::post('/update-page',[DynamicPagesController::class,'updatePage']);
Route::get('/search-page',[DynamicPagesController::class,'searchPage']);
// Blog
Route::get('/all-blogs',[BlogController::class,'allBlogs']);
Route::get('/create-blog',[BlogController::class,'createBlog']);
Route::post('/store-blog',[BlogController::class,'storeBlog']);
Route::post('/uploadbloagimage',[BlogController::class,'storeBlog']);
Route::get('/remove-blog',[BlogController::class,'removeBlog']);
Route::get('/edit-blog',[BlogController::class,'editBlog']);
Route::post('/update-blog',[BlogController::class,'updateBlog']);
Route::get('/serachBlog',[BlogController::class,'searchBlog']);
//Blog Category
Route::get('/all-blog-category',[BlogController::class,'allBlogCategory']);
Route::get('/add-blog-category',[BlogController::class,'createBlogCategory']);
Route::post('/store-blog-catgeory',[BlogController::class,'storeBlogCategory']);
Route::get('/remove-blog-category',[BlogController::class,'removeBlogCategory']);
Route::get('/edit-blog-category',[BlogController::class,'editBlogCategory']);
Route::post('/update-blog-category',[BlogController::class,'updateBlogCategory']);
Route::get('/search-blog-category',[BlogController::class,'serachBlogCategory']);
// Enquiry
Route::get('/all-enquiry',[EnquiryController::class,'allEnquiry']);
Route::get('/remove-enquiry',[EnquiryController::class,'deleteEnquiry']);
Route::get('/serach-enquiry',[EnquiryController::class,'searchEnquiry']);
// Category
Route::get('/remove-category',[CategoryController::class,'removeCategory']);
Route::get('/edit-category',[CategoryController::class,'editCategory']);
Route::post('/update-category',[CategoryController::class,'updateCategory']);

// NEW FEATURE
Route::get('/market-price',[ProductController::class,'marketPrice'])->name('marketPrice');
Route::post('/update-price',[ProductController::class,'updatePrice'])->name('update-price');
Route::get('/quoatation',[ProductController::class,'quoatation'])->name('quoatation');
Route::post('/create-quoatation',[ProductController::class,'createQuoatation'])->name('createQuoatation');
Route::get('/genrate-temp-data',[ProductController::class,'genrateTempData'])->name('genrateTempData');

// Products
Route::get('/all-products',[ProductController::class,'allProducts']);
Route::get('/add-product',[ProductController::class,'addProduct']);
Route::post('/upload-dropzone-files',[ProductController::class,'uploadDropzoneFiles']);
Route::post('/upload-dropzone-files-media',[ProductController::class,'uploadDropzoneFilesMedia']);
Route::post('/upload-dropzone-files-sample',[ProductController::class,'uploadDropzoneFilesSample']);
Route::post('/store-product',[ProductController::class,'storeProduct']);
Route::post('/upload-product-tinymce-image',[ProductController::class,'uploadProductTinymceImage']);
Route::post('/change-product-status',[ProductController::class,'changeProductStatus']);
Route::get('/edit-product',[ProductController::class,'editProduct']);
Route::get('/remove-demo-file',[ProductController::class,'removeDemoFile']);
Route::get('/remove-media-file',[ProductController::class,'removeMediaFile']);
Route::get('/remove-digital-file',[ProductController::class,'removeDigitalFile']);
Route::post('/update-product',[ProductController::class,'updateProduct']);
// Discounts
Route::get('/product-discounts',[DiscountController::class,'productDiscounts'])->name('product-discounts');
Route::get('/create-coupon',[DiscountController::class,'createCoupon'])->name('create-coupon');
Route::post('/store-coupon',[DiscountController::class,'storeCoupon'])->name('store-coupon');
Route::post('/change-coupon-status',[DiscountController::class,'changeCouponStatus']);
Route::get('/edit-coupon',[DiscountController::class,'editCoupon']);
Route::post('/update-coupon',[DiscountController::class,'updateCoupon']);
Route::get('/preview-product-image/{image}',[DiscountController::class,'previewProductImage']);
// Orders
Route::get('/all-orders',[OrderController::class,'viewAllOrders']);
Route::get('/order-detail/{id}',[OrderController::class,'viewOrderDetails']);
Route::controller(DiscountController::class)->group(function(){
    Route::match(['get', 'post'], 'upload-test', 'uploadTest');
});

// Route::get('show-file/{file}',function($file){
//     if(\Auth::check()){
//         $filepath = storage_path("app/test/".$file);
//         return response()->file($filepath);
//     }else{
//         return '-';
//     }
    
// });

Route::resources([
    'categories' => CategoryController::class,
]);

});

Route::get('/404', function () {
    abort(404);
});
