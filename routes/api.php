<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/portfolio', [App\Http\Controllers\TradeController::class, 'getPortfolio']);
Route::get('/snips/all', [App\Http\Controllers\SnipController::class, 'getAllSnips']);
Route::get('/unboxing/all', [App\Http\Controllers\SnipController::class, 'getAllUnboxing']);
Route::get('/token', [App\Http\Controllers\SnipController::class, 'generateBearer']);
Route::get('/check-bearer', [App\Http\Controllers\SnipController::class, 'checkBearer']);


Route::prefix("home")->group(function (){
    Route::get('/', [App\Http\Controllers\SnipController::class, 'getHomeData']);
    Route::get('/latest-snip', [App\Http\Controllers\SnipController::class, 'getCompanyShareholders']);
    Route::get('/unboxing-stock', [App\Http\Controllers\SnipController::class, 'getCompanyShareholdersNumber']);
});

Route::prefix("unboxing")->group(function (){
    Route::get('/{category}', [App\Http\Controllers\SnipController::class, 'getUnboxing']);
});



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', 'CustomAuthController@login');
    Route::post('/logout', 'CustomAuthController@logout');
    Route::post('/refresh', 'CustomAuthController@refresh');
    Route::any('/user-profile', 'CustomAuthController@me');
});
