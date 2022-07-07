<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/loginSignup',[AuthController::class,'loginSignup']);
Route::post('/deliverySignUp', [AuthController::class, 'deliverySignUp']);
Route::group(['middleware' => ['auth:sanctum']], function () {


    /**
     * Delivery Boy
     */
    
    Route::post('/deliveryActiveInactive', [AuthController::class, 'deliveryActiveInactive']);


    /**
     * CUSTOMER API
     */

   
    
    
    

    /**
     * VENDOR API
     */
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/updateProfile', [AuthController::class, 'UpdateProfile']);
    /**
     * PRODUCT RELATED API
     */
    Route::get('/getFamilyAttribute', [AuthController::class, 'getFamilyAttribute']);
    Route::post('/storeProduct', [AuthController::class, 'storeProduct']);
    Route::post('/updateProduct', [AuthController::class, 'updateProduct']);
    Route::get('/getProductDetails', [AuthController::class, 'getProductDetails']);
    Route::get('/getVendorProduct', [AuthController::class, 'getVendorProduct']);
    Route::get('/deleteVendorProduct', [AuthController::class, 'deleteVendorProduct']);
    Route::get('/getVendorOrders', [AuthController::class, 'getVendorOrders']);
    Route::post('/vendorUpdteOrder', [AuthController::class, 'vendorUpdteOrder']);
    Route::get('/getVendorTransaction', [AuthController::class, 'getVendorTransaction']);
    Route::post('/uploadImage', [AuthController::class, 'uploadImage']);
    Route::get('/productImageDelete', [AuthController::class, 'productImageDelete']);
    Route::post('/uploadVideo', [AuthController::class, 'uploadVideo']);
    Route::get('/productVideoDelete', [AuthController::class, 'productVideoDelete']);
    Route::get('/getProductImages', [AuthController::class, 'getProductImages']);
    Route::get('/getProductVideo', [AuthController::class, 'getProductVideo']);
    /**
     * Order Related API
     */
    Route::post('/updateVendorOrder', [AuthController::class, 'updateVendorOrder']);
    Route::post('/updateDeliveryBoyOrder', [AuthController::class, 'updateDeliveryBoyOrder']);

    Route::get('/getNewOrderDeliveryBoy', [AuthController::class, 'getNewOrderDeliveryBoy']);
    Route::get('/getActiveOrderDeliveryBoy', [AuthController::class, 'getActiveOrderDeliveryBoy']);
    Route::get('/getDeliveredOrderDeliveryBoy', [AuthController::class, 'getDeliveredOrderDeliveryBoy']);

    
});

Route::post('/complainSuggestion', [AuthController::class, 'complainSuggestion']);
Route::post('/vendorSignUp', [AuthController::class, 'vendorSignUp']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/deliveryLogin', [AuthController::class, 'deliverylogin']);
Route::post('/deliverySignup', [AuthController::class, 'deliverySignup']);
Route::get('/getCategory', [AuthController::class, 'getCategory']);
Route::get('/getChildCategory', [AuthController::class, 'getChildCategory']);

Route::get('/appUrl', [AuthController::class, 'appUrl']);

