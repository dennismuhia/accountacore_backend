<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\CountyApiController;
use App\Http\Controllers\Api\V1\NewsApiController;
use App\Http\Controllers\Api\V1\AccountController;


use App\Http\Controllers\RoleController;


Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test',function(){
    return response()->json(['heeelo'=> 'tet']);
});

Route::post('signup',[AccountController::class,'userSignUp']);
Route::post('login',[AccountController::class,'login']);
Route::post('verify_otp',[AccountController::class,'verifyOtp']);
Route::post("update/county",[AccountController::class,'updateCounty']);
Route::post("update/constituency",[AccountController::class,'updateConstituency']);
Route::post("update/subcounty",[AccountController::class,'updateSubCounty']);




// middleware('auth:sanctum')
Route::prefix('v1/accountacore')->group(function () {
    Route::get('/counties', [CountyApiController::class, 'getCounties']);
    Route::get('/regions/{county_id}', [CountyApiController::class, 'getRegionsByCounty']);
    Route::get('/subcounties/{region_id}', [CountyApiController::class, 'getSubcountiesByRegion']);
    Route::post('user/save-location', [CountyApiController::class, 'saveUserLocation']);
    Route::get('user_data/{id}',[AccountController::class,'getUser']);
    // Get News (National + Local)
    Route::get('/news/{user_id}', [NewsApiController::class, 'getNewsByLocation']);

    // Add News (Admin feature)
    Route::post('/news', [NewsApiController::class, 'store']);

    // Route::post('/addbookmark/{userid}/{newsId}',[NewsApiController::class,'addBookmark']);
    Route::get('fetch_user/bookmarks/{id}',[NewsApiController::class,'getUserBookmarks']);
    Route::get('/addbookmark/{userid}/{newsId}',[AccountController::class,'addBookmark']);
    Route::get('get-detailed-finacials/{newsId}',[NewsApiController::class,'getDetailedFinacials']);
    Route::get('/increase-news-view/user/{id}/{userId}',[NewsApiController::class,'increaseView']);
});

Route::post('add/role',[RoleController::class,'assignRoleToUser']);
