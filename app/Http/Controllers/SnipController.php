<?php

namespace App\Http\Controllers;

use App\Helper\IHSGHelper;
use App\Helper\StockbitHelper;
use Carbon\Carbon;
use GuzzleHttp\Client as guzzle;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Async\Pool;

class SnipController extends Controller
{

    private $client;
    private $exodus;

    public function __construct()
    {
        $this->client = new guzzle();
        $this->exodus = 'https://exodus.stockbit.com/';
    }

    function checkBearer()
    {
        return $this->generateBearer() . "<br>yaya";
    }

    function generateBearer()
    {
        // Check if the token is already in cache
        $bearerToken = session('exodus_token');

        if (!$bearerToken) {
            // Token is not in cache, generate a new one
            $response = $this->client->post('https://stockbit.com/api/login/email', [
                'form_params' => [
                    'username' => 'firriezky@gmail.com',
                    'password' => '1usykurillah',
                ],
            ]);

            $contents = $response->getBody()->getContents();
            $responseArray = json_decode($contents);
            $bearerToken = $responseArray->data->access->token;


            // Store the token in cache for 60 minutes
            session(['exodus_token' => $bearerToken]);
            session()->save();
            session()->put('exodus_token_expiry', now()->addHours(9));
        }

        return 'Bearer ' . $bearerToken;
    }

    private function makeRequest($categoryId, $lastId)
    {
        $url = $this->exodus . "research?";
        if ($lastId != null) {
            $url .= "last_id=$lastId";
        }
        if ($categoryId != null) {
            $url .= "&category_id=$categoryId";
        }

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->generateBearer(),
            ],
        ]);

        $contents = $response->getBody()->getContents();
        return json_decode($contents);
    }

    private function makeRequestUnboxing($category)
    {
        $url = $this->exodus . "academy/unboxing?";
        if ($category != null) {
            $url .= "category=$category";
        }

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->generateBearer(),
            ],
        ]);

        $contents = $response->getBody()->getContents();
        return json_decode($contents);
    }



    public function getAllSnips(Request $request)
    {
        $cacheKey = 'allSxxnipzzs' . $request->last_id."x".$request->limit."y".$request->category_id;
        $maxItems = 99999;

        if ($request->limit != null) {
            $maxItems=$request->limit;
        }

        // Check if the result is cached
       if (Cache::has($cacheKey)) {
           $modifiedResponse = Cache::get($cacheKey);
           return $modifiedResponse;
       }

        $allData = collect();

        $response = $this->makeRequest($request->category_id, $request->last_id);
        $counter = 0;

        while (!empty($response->data) && $counter < $maxItems) {
            $response->data = collect($response->data)->map(function ($item) {
                if (in_array($item->id, [1, 2, 3, 356])) {
                    $item->fey_cover = "sabam";
                    $item->description .= '<br><br><strong>New Element:</strong> This is a new element';
                }
                return $item;
            });

            $allData = $allData->merge($response->data);
            $reqLastId = $response->data->first()->id;
            $response = $this->makeRequest($request->category_id, $reqLastId);
            $counter += count($response->data);
            if ($counter >= $maxItems) {
                $allData = $allData->slice(0, $maxItems);
                break;
            }
        }

        $modifiedResponse = new \stdClass();
        $modifiedResponse->message = $response->message;
        $modifiedResponse->item_count = $allData->count();
        $modifiedResponse->data = $allData->toArray();

        // Cache the result
        Cache::put($cacheKey, $modifiedResponse, now()->addDay()); // 60 minutes expiration time

        return $modifiedResponse;
    }

    public function getUnboxing(Request $request,$category){

        if ($request->category=="sectoral"){
            $category="UNBOXING_CATEGORY_SECTOR";
        }

        if ($request->category=="stock"){
            $category="UNBOXING_CATEGORY_EMITTEN";
        }

        if ($request->category=="all"){
            $category=null;
        }

        $data = $this->makeRequestUnboxing($category);
        $data->data = collect($data->data)->map(function ($item) {
            if (in_array($item->id, [204])) {
                $item->fey_cover = "sabam";
                $item->thumbnail_url = "http://feylabs.my.id/fm/dummy/snip/unboxing_electric_vehicle.png";
                $item->description .= '<br><br><strong>New Element:</strong> This is a new element';
            }
            if (in_array($item->id, [34])) {
                $item->thumbnail_url = "http://feylabs.my.id/fm/dummy/snip/unboxing_menara.png";
            }
            if (in_array($item->id, [199])) {
                $item->thumbnail_url = "http://feylabs.my.id/fm/dummy/snip/unboxing_rokok.png";
            }
            if (in_array($item->id, [202])) {
                $item->thumbnail_url = "http://feylabs.my.id/fm/dummy/snip/unboxing_seasonality.png";
            }
            if (in_array($item->id, [4])) {
                $item->thumbnail_url = "http://feylabs.my.id/fm/dummy/snip/unboxing_properti.png";
            }
            if (in_array($item->id, [203])) {
                $item->thumbnail_url = "http://feylabs.my.id/fm/dummy/snip/unboxing_konstruksi.png";
            }

//            34,203,202,199,4,
            return $item;
        });

        $data->item_count = $data->data->count();
        return $data;
    }

    public function getHomeData(Request $request){
        $modifiedResponse = new \stdClass();
        $event = $this->makeRequest(2,null);
        $snip = $this->makeRequest(4,null);

        $modifiedResponse->menu_unboxing_sectoral=$this->getUnboxing($request,"sectoral")->data;
        $modifiedResponse->menu_event=$event;
        $modifiedResponse->menu_unboxing_saham=$this->getUnboxing($request,"stock")->data;
        $modifiedResponse->menu_snip=$snip;

        return $modifiedResponse;
    }




    public function getAllUnboxing(Request $request)
    {
        $data = $this->makeRequest(4, $request->last_id);

        $data->data = collect($data->data)->map(function ($item) {
            if (in_array($item->id, [1, 2, 3, 356])) {
                $item->fey_cover = "sabam";
                $item->description .= '<br><br><strong>New Element:</strong> This is a new element';
            }
            return $item;
        });

        $data->item_count = $data->data->count();
        return $data;
    }


    public function getCommonItem(Request $request)
    {
        $categoryId = 0;
        $lastId = null;

        if ($request->category == "snips") {
            $categoryId = 1;
        }
        if ($request->category == "events") {
            $categoryId = 2;
        }
        if ($request->category == "unboxing") {
            $categoryId = 4;
        }

        if ($request->last_id != null) {
            $lastId = $request->last_id;
        }

        $data = $this->makeRequest($categoryId, $lastId);
        $data->data = collect($data->data)->map(function ($item) {
            if (in_array($item->id, [1, 2, 3, 356])) {
                $item->fey_cover = "sabam";
                $item->description .= '<br><br><strong>New Element:</strong> This is a new element';
            }
            return $item;
        });

        $data->item_count = $data->data->count();

        return $data->toJson();
    }
}
