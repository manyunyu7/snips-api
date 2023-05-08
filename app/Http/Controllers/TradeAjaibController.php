<?php

namespace App\Http\Controllers;

use App\Helper\AjaibHelper;
use Carbon\Carbon;
use GuzzleHttp\Client as guzzle;
use Illuminate\Http\Request;

class TradeAjaibController extends Controller
{

    protected $xc = 'https://ht2.ajaib.co.id/api/v1/';


    public function getOrderBook($emiten)
    {
        $client = new guzzle();
        $url = $this->xc . "stock/bestquote/?code=$emiten";
        $response = $client->request('GET', $url, [
            'headers' => AjaibHelper::getTradeHeader(),
        ]);

        return $response->getBody()->getContents();
    }

    public function buy(
        $emiten,$price,$lot
    )
    {
        $url =  $this->xc . "stock/buy";
        $emiten = $emiten;
        $price = $price;
        $lot = $lot;
        $formParams = [
            'ticker_code' => $emiten,
            'price' => $price,
            'lot' => $lot,
            'board' => '0RG',
            'period' => 'day',
        ];

        $headers = AjaibHelper::getTradeHeader();

        $client = new guzzle();
        $response = $client->post("$url", [
            'form_params' => $formParams,
            'headers' => $headers
        ]);

        $responseBody = $response->getBody()->getContents();
        return $responseBody;
    }

    public function cancel(
        $orderId, $emiten
    )
    {
        $url = $this->stockbit . "order/cancel";
        $formParams = [
            'orderkey' => "W-WITHDRAW-" . Carbon::now(),
            'symbol' => $emiten,
            'orderid' => $orderId,
            'gtc' => 0,
        ];
        $headers = [
            'Authorization' => $this->generateBearerTrade(),
        ];

        $client = new guzzle();
        $response = $client->post("$url", [
            'form_params' => $formParams,
            'headers' => $headers
        ]);
        $responseBody = $response->getBody()->getContents();
        return $responseBody;
    }


    public function sell(
        $lot, $emiten, $price
    )
    {
        $url = $this->stockbit . "order/sell";
        $emiten = $emiten;
        $price = $price;
        $lot = $lot;
        $formParams = [
            'orderkey' => "W-SELL-" . Carbon::now(),
            'symbol' => $emiten,
            'price' => $price,
            'shares' => $lot * 100,
            'boardtype' => 'rg',
            'gtc' => 0,
        ];
        $headers = [
            'Authorization' => $this->generateBearerTrade(),
        ];

        $client = new guzzle();
        $response = $client->post("$url", [
            'form_params' => $formParams,
            'headers' => $headers
        ]);
        $responseBody = $response->getBody()->getContents();
        return $responseBody;
    }

}
