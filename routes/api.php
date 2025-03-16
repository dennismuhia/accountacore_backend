<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CountyApiController;
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

    // middleware('auth:sanctum')
    Route::prefix('accountacore')->group(function () {
        Route::get('/counties', [CountyApiController::class, 'getCounties']);
        Route::get('/regions/{county_id}', [CountyApiController::class, 'getRegionsByCounty']);
        Route::get('/subcounties/{region_id}', [CountyApiController::class, 'getSubcountiesByRegion']);
        Route::post('user/save-location',[CountyApiController::class,'saveUserLocation']); 
    });
