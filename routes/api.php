<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	
	dd($request);
    return $request->user();
});

/*Route::get('/login', function () {
     $this->content['status']=false;
	 $this->content['message'] = "unauthorized access : Access Token is expired,Please re login";
	 $this->content['data']="";
	 $status = 200;
	 
	 return response()->json($this->content, $status);
})->name('login');*/

Route::post('/registerMerchant', 'ApiController@registerVendor');// done
Route::post('/authenticateMerchant', 'ApiController@authenticateMerchant');// done
Route::post('/resendEmailVerification/merchant', 'ApiController@resendEmailVerificationMerchant');
Route::post('/forgotPassword/merchant', 'Auth\ForgotPasswordController@sendResetLinkEmail');//done
Route::get('/sendNotication','ApiController@sendNotification');
Route::middleware('auth:api')->post('/updatePassword', 'ApiController@changePassword'); // done
Route::middleware('auth:api')->post('/updateProfile', 'ApiController@updateProfile'); // done
Route::post('/authenticate', 'ApiController@authenticate');// done
Route::post('/getNotification','ApiController@getNotification');
Route::post('/register', 'ApiController@register');// done
Route::post('/updateFCM', 'ApiController@updateFCM');// done
Route::post('/resendEmailVerification', 'ApiController@resendEmailVerification');
Route::post('/forgotPassword', 'Auth\ForgotPasswordController@sendResetLinkEmail');//done
// Route::post('/resendOTP','ApiController@resendOTP');
// Route::post('/forgotPassword', 'ApiController@forgotPassword');// done

Route::middleware('auth:api')->post('/getNearByRestaurant', 'ApiController@getNearByRestaurant');//done
Route::middleware('auth:api')->post('/filterRestaurant', 'ApiController@filterRestaurant');//done
Route::middleware('auth:api')->get('/listCuisene', 'ApiController@listCuisene');//done
Route::middleware('auth:api')->post('/listmenus/', 'ApiController@listMenuByRestaurant');//done
Route::middleware('auth:api')->post('/getRestaurentDetails/', 'ApiController@restaurantDetails');//done
Route::middleware('auth:api')->post('/addReview', 'ApiController@addReview');
Route::middleware('auth:api')->post('/createOrder', 'ApiController@createOrder');
Route::middleware('auth:api')->post('/editReview', 'ApiController@editReview');
Route::middleware('auth:api')->post('/getRatingByRestaurant', 'ApiController@getRatingByRestaurant');
Route::middleware('auth:api')->post('/addAddress', 'ApiController@addAddress');
Route::middleware('auth:api')->post('/updateAddress', 'ApiController@updateAddress');
Route::middleware('auth:api')->post('/updateMobile', 'ApiController@updateMobile');
Route::middleware('auth:api')->post('/resendOTP','ApiController@resendOTP');
Route::middleware('auth:api')->post('/verifyMobile', 'ApiController@verifyMobile');
Route::middleware('auth:api')->post('/removeAddress', 'ApiController@removeAddress');
Route::middleware('auth:api')->get('/listAddresses', 'ApiController@listAddresses');
Route::middleware('auth:api')->get('/listOrders/', 'ApiController@listUserOrders');
Route::middleware('auth:api')->post('/listRestaurantOrders/', 'ApiController@listRestaurantOrders');
Route::middleware('auth:api')->post('/updateOrderStatus/', 'ApiController@updateOrderStatus');
Route::middleware('auth:api')->get('/profileDetails', 'ApiController@profileDetails');
Route::middleware('auth:api')->get('/getOffers', 'ApiController@getOffers');
Route::middleware('auth:api')->post('/isVerifiedUser', 'ApiController@isVerifiedUser');

Route::post('/resetotp', 'ApiController@resetotp');
Route::post('/resetpassword', 'ApiController@resetpassword');

