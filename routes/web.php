<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SummerNoteController;


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

Route::prefix('trade')->group(function () {
    Route::get('crawl/orderbook/{emiten}', 'TradeController@crawlOrderbook');

    Route::prefix("screener")->group(function (){
        Route::get('/dps-min', [App\Http\Controllers\TradeController::class, 'screenDecreasedShareholder']);
        Route::get('/dps-plus', [App\Http\Controllers\TradeController::class, 'screenIncreasedShareholder']);
    });

    Route::prefix("company")->group(function (){
        Route::get('/{code}/profile', [App\Http\Controllers\TradeController::class, 'getCompanyProfile']);
        Route::get('/{code}/shareholder', [App\Http\Controllers\TradeController::class, 'getCompanyShareholders']);
        Route::get('/{code}/shareholder-number', [App\Http\Controllers\TradeController::class, 'getCompanyShareholdersNumber']);
    });

    Route::get('/portfolio', [App\Http\Controllers\TradeController::class, 'getPortfolio']);
    Route::get('/emiten/all', [App\Http\Controllers\TradeController::class, 'getEmiten']);
    Route::get('/portfolio/trading-balance', [App\Http\Controllers\TradeController::class, 'getTradingBalance']);
    Route::get('/portfolio/composition', [App\Http\Controllers\TradeController::class, 'getStockComposition']);
    Route::get('/check/{code}', [App\Http\Controllers\TradeController::class, 'checkEmitenOnPortfolio']);
    Route::get('/check/{code}/checkLot', [App\Http\Controllers\TradeController::class, 'checkIfLotAvailable']);
    Route::get('{code}/orderbook', [App\Http\Controllers\TradeController::class, 'getOrderBook']);


    Route::any('buy', [App\Http\Controllers\TradeController::class, 'buy']);
    Route::any('sell', [App\Http\Controllers\TradeController::class, 'sell']);
    Route::any('cancel/{emiten}/{orderId}', [App\Http\Controllers\TradeController::class, 'cancel']);

    Route::any('odt-return', [App\Http\Controllers\TradeController::class, 'getDayTradeReturn']);
    Route::any('orders', [App\Http\Controllers\TradeController::class, 'orders']);
    Route::any('orders/{status}', [App\Http\Controllers\TradeController::class, 'ordersByStatus']);

    Route::any('{code}/automate/beautify/bid/{nominal}', [App\Http\Controllers\TradeController::class, 'beautifyBidVolumes']);
    Route::any('{code}/automate/beautify/offer/{nominal}', [App\Http\Controllers\TradeController::class, 'beautifyOfferVolumes']);
    Route::any('withdraw/all', [App\Http\Controllers\TradeController::class, 'cancelAllOrder']);
    Route::any('bid88', [App\Http\Controllers\TradeController::class, 'bid88']);
    Route::any('offer88', [App\Http\Controllers\TradeController::class, 'offer88']);
    Route::view('156', "trade.157");

    Route::any('stream/{code}', [App\Http\Controllers\TradeController::class, 'getStreamOnEmiten']);
    Route::any('stream/write', [App\Http\Controllers\TradeController::class, 'writeStream']);
    Route::any('stream/{code}/content-only', [App\Http\Controllers\TradeController::class, 'getStreamContentOnly']);

    Route::any('yeay', [App\Http\Controllers\TradeController::class, 'yey']);
    Route::any('download-images', [App\Http\Controllers\TradeController::class, 'downloadImages']);

});

Route::get('/excel', [App\Http\Controllers\ExcelController::class, 'index']);

Route::post('summernote-image', [SummerNoteController::class, 'store']);
Route::post('summernote-image-delete', [SummerNoteController::class, 'destroyImage']);

