<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/',[FrontendController::class,'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/product/category/list/{id?}/{product_name?}/{sort?}', [FrontendController::class, 'getproductByCategoryId'])->name('product-category-list');
Route::get('/product/details/{name}/{id}', [FrontendController::class, 'getProductDetails'])->name('product_details');
Route::post('/add_to_cart/{id}', [FrontendController::class, 'addToCart'])->name('add_to_cart');
Route::get('/cart/remove/', [FrontendController::class, 'removeCart'])->name('cart.remove');
Route::get('cart-list/', [FrontendController::class, 'cartList'])->name('cart-list');
Route::get('cart/delete/product/{id}', [FrontendController::class, 'cartDeleteProduct'])->name('cart.delete.product');
Route::get('user/login/show', [FrontendController::class, 'showLoginForm'])->name('user.login.show');
Route::post('user/otp/send', [FrontendController::class, 'otpSend'])->name('user.otp.send');
Route::post('user/otp/verification', [FrontendController::class, 'otpVerication'])->name('user.otp.verification');
Route::get('user/register/show', [FrontendController::class, 'showRegisterForm'])->name('user.register.show');
Route::get('sellers/product/{id}', [FrontendController::class, 'sellerProduct'])->name('sellers.product');
Route::get('new-realease/{sort?}', [FrontendController::class, 'newRealease'])->name('new-realease');
Route::get('best-sell/product/{sort?}', [FrontendController::class, 'bestSellProduct'])->name('best-sell');
Route::get('brand/category', [FrontendController::class, 'getCategoryBrand'])->name('brand.category');
Route::get('how-it-works', [FrontendController::class, 'howItWorks'])->name('how.it.works');
Route::get('shipping-return', [FrontendController::class, 'shippingReturn'])->name('shipping.return');
Route::get('blogs', [FrontendController::class, 'blogs'])->name('blogs');
Route::get('blog_single', [FrontendController::class, 'blogSingle'])->name('blog_single');
Route::get('contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('contact/submit', [FrontendController::class, 'contactSubmit'])->name('contact.submit');
Route::get('blog/single/{id}', [FrontendController::class, 'blogDetails'])->name('blog.details');
Route::post('blog/like/dislike', [FrontendController::class, 'blogLikeDislike'])->name('blog.update.likedislike');
Route::post('customer/blog/rating', [FrontendController::class, 'customerBlogRating'])->name('customer.blog.rating');
Route::post('customer/product/rating', [FrontendController::class, 'customerProductRating'])->name('customer.product.rating');
Route::get('checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::post('add_address', [FrontendController::class, 'addAddress'])->name('add.address');
Route::post('order/place', [FrontendController::class, 'orderPlace'])->name('order.place');
Route::get('cart_done', [FrontendController::class, 'cartDone'])->name('cart_done');
Route::get('checkCoupon', [FrontendController::class, 'checkCoupon']);
Route::get('order/list', [FrontendController::class, 'orderList'])->name('order.list');
Route::get('profile/view', [FrontendController::class, 'getProfile'])->name('profile.view');
Route::post('profile/update', [FrontendController::class, 'updateProfile'])->name('profile.update');
Route::get('privacy/policy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('terms-conditions', [FrontendController::class, 'termsConditions'])->name('terms');
Route::get('about', [FrontendController::class, 'about'])->name('about');
Route::get('return/policy', [FrontendController::class, 'returnPolicy'])->name('return.policy');

Route::get('privacy-policy/app/{type}',[AppSettingController::class,'privacyPolicy']);
Route::get('term-condition/app/{type}',[AppSettingController::class,'termCondition']);
Route::get('about/app/{type}',[AppSettingController::class,'about']);

Route::post('image-upload', 'BannerController@imageUploadPost')->name('image.upload.post');





