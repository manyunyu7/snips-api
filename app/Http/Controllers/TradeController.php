<?php

namespace App\Http\Controllers;

use App\Helper\IHSGHelper;
use App\Helper\StockbitHelper;
use Carbon\Carbon;
use GuzzleHttp\Client as guzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Async\Pool;

class TradeController extends Controller
{

    protected $exodus = 'https://exodus.stockbit.com/';
    protected $stockbit = 'https://trading.masonline.id/';

    public function generateBearer()
    {
        return StockbitHelper::getBearerToken();
    }

    public function generateBearerTrade()
    {
        return StockbitHelper::getBearerTokenTrade();
    }

    public function getEmiten()
    {
        return json_decode(IHSGHelper::getEmitenList());
    }

    public function getRandom()
    {
        // return [888, 777, 168];
        // return [167, 168, 88, 77, 123, 668, 222, 669, 11, 888, 999, 777, 666, 555, 444, 333, 222, 111, 168, 168, 168];
        // return [868, 769, 667, 766, 665, 123, 788, 168, 123, 11, 22, 33, 44, 55, 66, 77, 168, 168, 168, 168, 168, 168, 168];
        return [888, 777, 168, 168, 168, 555, 222, 111, 737, 555, 222,989,989, 111,555, 555,123,123,123];
    }

    public function getRandomJemur()
    {
        return [16, 17, 18, 19, 20, 21, 22];
    }

    public function crawlOrderbook($emiten)
    {
        return view("trade.orderbook")->with(compact('emiten'));
    }

    public function bid88()
    {
        return view("trade.bid");
    }

    public function offer88()
    {
        return view("trade.offer");
    }

    public function getOrderBook($emiten)
    {
        $client = new guzzle();
        $url = $this->exodus . "orderbook/companies/$emiten";
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->generateBearer(),
            ],
        ]);

        // $orderbookResponse = json_decode($response->getBody()->getContents());
        //        // Create the date and symbol folders if they don't exist
        //        $date = date("Y_m_d");
        //        $path = public_path("orderbook_history/$date/$emiten");
        //        if (!file_exists($path)) {
        //            mkdir($path, 0777, true);
        //        }
        //        $time = Carbon::now();
        //        // Create the filename using the timestamp
        //        $filename = $time->format("Y_m_d_H_i_s") . ".json";
        //        // Write the data to the file
        //        File::put("$path/$filename", json_encode($orderbookResponse));

        //        echo json_encode($orderbookResponse);
        return $response->getBody()->getContents();
    }

    public function getCompanyProfile($emiten)
    {
        $client = new guzzle();
        $url = $this->exodus . "emitten/$emiten/profile";
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->generateBearer(),
            ],
        ]);

        return $response->getBody()->getContents();
    }

    public function getCompanyShareholders($emiten)
    {
        $data = json_decode($this->getCompanyProfile($emiten));
        return $data;
    }

    public function getCompanyShareholdersNumber($emiten)
    {
        $data = json_decode($this->getCompanyProfile($emiten));
        return $data->data->shareholder_numbers;
    }

    public function screenDecreasedShareholder()
    {
        $data = $this->getEmiten();
        //        $data = array("NICL","BUKA","GOTO");
        $constantDecreaseData = array();
        //        $limit = 5; // replace with your desired limit
        $limit = count($data);
        for ($i = 0; $i < $limit; $i++) {
            $dataset = $data[$i];
            if (strlen($dataset) == 4) {
                $decreasing = true;
                $lastFetchedDate = "";
                $networkData = $this->getCompanyShareholdersNumber($dataset); // make network call for each emiten
                if (empty($networkData)) {
                    $decreasing = false;
                } else {
                    foreach ($networkData as $key => $entry) {

                        $first_month_shareholder_count = intval(str_replace(',', '', $networkData[0]->total_share));
                        $last_month_shareholder_count = intval(str_replace(',', '', end($networkData)->total_share));
                        $lastFetchedDate = $networkData[0]->shareholder_date;

                        $percentage_change = 0;

                        if (is_numeric($first_month_shareholder_count) && is_numeric($last_month_shareholder_count)) {
                            $percentage_change = ($last_month_shareholder_count - $first_month_shareholder_count) / $first_month_shareholder_count * 100;
                        }

                        // check if there is "+" in change_formatted
                        if (strpos($entry->change_formatted, '+') !== false) {
                            $decreasing = false;
                            break;
                        }
                        // update the last fetched date
                        $lastFetchedDate = $entry->shareholder_date;
                    }
                }

                if ($decreasing) {
                    // create the directory path
                    $date = new \DateTime();
                    $current_month_year = $date->format('F-Y');
                    $directory_path = './dps-min/' . $current_month_year . '/';
                    if (!is_dir($directory_path)) {
                        mkdir($directory_path, 0777, true);
                    }
                    // save the data to file
                    $file_name = $dataset . '.json';
                    $file_path = $directory_path . $file_name;
                    $data_to_save = array(
                        'emiten' => $dataset,
                        'shareholder_decrease' => "-" . $last_month_shareholder_count - $first_month_shareholder_count,
                        'shareholder_percentage_change' => $percentage_change,
                        'percentage_change_formatted' => number_format($percentage_change),
                        'last_shareholder_count' => $last_month_shareholder_count,
                        'first_shareholder_count' => $first_month_shareholder_count,
                        'data' => $networkData,
                    );
                    //                    $json_data = json_encode($data_to_save, JSON_PRETTY_PRINT);
                    array_push($constantDecreaseData, $data_to_save);
                    //                    $txt_data = print_r($data_to_save, true);
                    //                    file_put_contents($file_path.'.txt', $txt_data);
                }
            }
        }


        // Create an array of the "shareholder_percentage_change" values
        $percentageChanges = array_column($constantDecreaseData, 'shareholder_percentage_change');

        // Sort the original data array based on the "shareholder_percentage_change" values
        array_multisort($percentageChanges, SORT_DESC, $constantDecreaseData);

        $generation = 1;
        foreach ($constantDecreaseData as $data) {
            if ($generation < 10) {
                $generation = sprintf("%02d", $generation);
            }

            $now = Carbon::now();
            $month = $now->month;
            $year = $now->year;
            $monthName = $now->format('F');
            $file_path = $file_name;

            $directory_path = './dps-min/' . $current_month_year . '/';

            if (!is_dir($directory_path)) {
                mkdir($directory_path, 0777, true);
            }

            $file_path = $directory_path . $generation . '_' . $data['emiten'];


            $txt_data = print_r($data, true);
            file_put_contents($file_path . '.txt', $txt_data);
            $generation++;
        }

        return json_encode($constantDecreaseData);
    }

    public function screenIncreasedShareholder()
    {
        $data = $this->getEmiten();
        //        $data = array("NICL","BUKA","GOTO");
        $constantDecreaseData = array();
        //        $limit = 5; // replace with your desired limit
        $limit = count($data);
        for ($i = 0; $i < $limit; $i++) {
            $dataset = $data[$i];
            if (strlen($dataset) == 4) {
                $decreasing = true;
                $lastFetchedDate = "";
                $networkData = $this->getCompanyShareholdersNumber($dataset); // make network call for each emiten
                if (empty($networkData)) {
                    $decreasing = false;
                } else {
                    foreach ($networkData as $key => $entry) {

                        $first_month_shareholder_count = intval(str_replace(',', '', $networkData[0]->total_share));
                        $last_month_shareholder_count = intval(str_replace(',', '', end($networkData)->total_share));

                        $percentage_change = 0;

                        if (is_numeric($first_month_shareholder_count) && is_numeric($last_month_shareholder_count)) {
                            $percentage_change = ($last_month_shareholder_count - $first_month_shareholder_count) / $first_month_shareholder_count * 100;
                        }

                        // check if there is "+" in change_formatted
                        if (strpos($entry->change_formatted, '-') !== false) {
                            $decreasing = false;
                            break;
                        }
                        // update the last fetched date
                        $lastFetchedDate = $entry->shareholder_date;
                    }
                }

                if ($decreasing) {
                    // create the directory path
                    $date = new \DateTime();
                    $current_month_year = $date->format('F-Y');
                    $directory_path = './dps-max/' . $current_month_year . '/';
                    if (!is_dir($directory_path)) {
                        mkdir($directory_path, 0777, true);
                    }
                    // save the data to file
                    $file_name = $dataset . '.json';
                    $file_path = $directory_path . $file_name;
                    $data_to_save = array(
                        'emiten' => $dataset,
                        'shareholder_decrease' => $last_month_shareholder_count - $first_month_shareholder_count,
                        'shareholder_percentage_change' => $percentage_change,
                        'last_shareholder_count' => $last_month_shareholder_count,
                        'first_shareholder_count' => $first_month_shareholder_count,
                        'percentage_change_formatted' => -number_format($percentage_change),
                        'data' => $networkData,
                    );
                    //                    $json_data = json_encode($data_to_save, JSON_PRETTY_PRINT);
                    array_push($constantDecreaseData, $data_to_save);
                    //                    $txt_data = print_r($data_to_save, true);
                    //                    file_put_contents($file_path.'.txt', $txt_data);
                }
            }
        }


        // Create an array of the "shareholder_percentage_change" values
        $percentageChanges = array_column($constantDecreaseData, 'shareholder_percentage_change');

        // Sort the original data array based on the "shareholder_percentage_change" values
        array_multisort($percentageChanges, SORT_DESC, $constantDecreaseData);

        $generation = 1;
        foreach ($constantDecreaseData as $data) {
            if ($generation < 10) {
                $generation = sprintf("%02d", $generation);
            }

            $now = Carbon::now();
            $month = $now->month;
            $year = $now->year;
            $monthName = $now->format('F');
            $file_path = 'dps-max/' . $generation . '_' . $data['emiten'];

            $txt_data = print_r($data, true);
            file_put_contents($file_path . '.txt', $txt_data);
            $generation++;
        }

        return json_encode($constantDecreaseData);
    }

    public function getPortfolio()
    {
        $client = new guzzle();
        $url = $this->stockbit . "portfolio";
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->generateBearerTrade(),
            ],
        ]);

        $contents = $response->getBody()->getContents();
        $json = json_decode($contents);
        // return response()->json($json);
        return $contents;
    }
    public function getTradingBalance()
    {
        $portfolioData = json_decode($this->getPortfolio());
        return $portfolioData->data->tradingbalance;
    }

    public function checkEmitenOnPortfolio($emiten)
    {
        $raw = $this->getPortfolio();
        $portfolioData = json_decode($raw);
        // Iterate through the result array and search for the emiten with the specified symbol
        foreach ($portfolioData->data->result as $emitenObject) {
            if ($emitenObject->symbol == $emiten) {
                // Return the emiten object if it is found
                return $emitenObject;
            }
        }

        // Return null if the emiten is not found
        return null;
    }

    public function getDayTradeReturn()
    {
        $responseRaw = json_decode($this->orders()); //decode json response
        $response = $responseRaw;

        $emiten = array();
        foreach ($response->data as $order) {
            if ($order->status == "MATCH" && $order->action == "SELL") {
                if (isset($emiten[$order->symbol]['sell_total'])) {
                    $emiten[$order->symbol]['sell_total'] += $order->amount;
                } else {
                    $emiten[$order->symbol]['sell_total'] = $order->amount;
                }
            } elseif ($order->status == "MATCH" && $order->action == "BUY") {
                if (isset($emiten[$order->symbol]['buy_total'])) {
                    $emiten[$order->symbol]['buy_total'] += $order->amount;
                } else {
                    $emiten[$order->symbol]['buy_total'] = $order->amount;
                }
            }
        }


        $result = array();
        foreach ($emiten as $symbol => $data) {
            if (isset($data['sell_total']) && isset($data['buy_total'])) {
                $buy_avg = $data['buy_total'] / $data['buy_count'];
                $sell_total = $data['sell_total'];
                $gain_loss = $sell_total - ($buy_avg * $data['sell_count']);
                $result[] = array(
                    "emiten" => $symbol,
                    "gain_loss" => $gain_loss
                );
            }
        }

        return json_encode(array("data" => $result));
    }

    public function checkIfLotAvailable($emiten)
    {
        $raw = $this->checkEmitenOnPortfolio($emiten);
        return $raw->available_lot;
    }

    public function getStreamContentOnly($emiten)
    {
        $data = json_decode($this->getStreamOnEmiten($emiten));
        $data = $data->data;
        $contentOriginal = array();
        foreach ($data as $item) {
            $contentOriginal[] = $item->content_original;
        }
        return $contentOriginal;
    }

    public function getStreamOnEmiten($emiten)
    {
        $url = $this->exodus . "stream/v2/symbol/$emiten";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "category": "all",
            "keyword": "",
            "limit": 100,
            "to_date": "",
            "from_date": ""
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZSI6ImlraHNhbmF6aXoiLCJlbWEiOiJtdWhhbW1hZGlraHNhbmFiZHVsYXppekBnbWFpbC5jb20iLCJmdWwiOiJUcmlhbDI5Iiwic2VzIjoibjJsZkJKWEhBNFBtUlJFUiIsImR2YyI6IiIsInVpZCI6MTM5MTIyMX0sImV4cCI6MTY3MjExNTkzOSwianRpIjoiMDRhZmFiZDMtODVjZC00OWY0LTg4N2QtMjEyOWZjMWE4ZjBiIiwiaWF0IjoxNjcyMDI5NTM5LCJpc3MiOiJTVE9DS0JJVCIsIm5iZiI6MTY3MjAyOTUzOX0.kiUK4RTYz7-pO2VnBaSJjGkQOhkwTA21WpbKnGCVgCs',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function writeStream()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->exodus . "stream/write",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
              "content": "$NICL otw 19000",
              "image": "",
              "file": "",
              "sharefacebook": 0,
              "sharetwitter": 0,
              "target_price": "0.000000",
              "target_symbol": "",
              "target_duration": "7",
              "images": [],
              "commenter_type": "COMMENTER_TYPE_EVERYONE"
            }',
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . $this->generateBearer(),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function downloadImages()
    {
        $data = $this->getEmiten();
        //        $data = array("NICL","BUKA","GOTO");
        $constantDecreaseData = array();
        //        $limit = 5; // replace with your desired limit
        $limit = count($data);
        for ($i = 0; $i < $limit; $i++) {
            $dataset = $data[$i];
            if (strlen($dataset) == 4) {
                $url = "https://assets.stockbit.com/logos/companies/$dataset.png";
                $headers = get_headers($url);
                $code = substr($headers[0], 9, 3);
                if ($code != 404 && $code != 403) {
                    $contents = file_get_contents($url);
                    $name = "emiten/icon/" . "$dataset." . "png";
                    Storage::put($name, $contents);
                }
            }
        }
    }



    public function yey()
    {
        $a = array();
        for ($x = 0; $x <= 1784; $x++) {
            //            $random = $this->getRandomJemur();
            //            $nominal = $random[array_rand($random)];
            array_push($a, $this->sell(1, "NICL-W", 15));
            usleep(500);
        }
        return $a;
    }

    public function buy(
        $lot,
        $emiten,
        $price
    ) {
        $url = $this->stockbit . "order/buy";
        $emiten = $emiten;
        $price = $price;
        $lot = $lot;
        $formParams = [
            'orderkey' => "W-BUY-" . Carbon::now('Asia/Jakarta')->timestamp,
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

    public function cancel(
        $orderId,
        $emiten
    ) {
        $url = $this->stockbit . "order/cancel";
        $formParams = [
            'orderkey' => "W-WITHDRAW-" . Carbon::now('Asia/Jakarta')->timestamp,
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
        $lot,
        $emiten,
        $price
    ) {
        $url = $this->stockbit . "order/sell";
        $emiten = $emiten;
        $price = $price;
        $lot = $lot;
        $formParams = [
            'orderkey' => "W-SELL-" . Carbon::now('Asia/Jakarta')->timestamp,
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

    public function orders()
    {
        $client = new guzzle();
        $url = $this->stockbit . "order/list?gtc=1";
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->generateBearerTrade(),
            ],
        ]);

        $contents = $response->getBody()->getContents();
        $json = json_decode($contents);
        // return response()->json($json);
        return $contents;
    }

    public function ordersByStatus($status = "OPEN")
    {
        $orders = json_decode($this->orders())->data;
        $filteredOrders = array_filter($orders, function ($order) {
            return $order->status == "OPEN";
        });

        return $filteredOrders;
    }

    public function cancelAllOrder($type, $code = null, $beautify = null)
    {
        $orders = json_decode($this->orders());

        $orderIds = [];
        shuffle($orders->data);  // shuffle the array randomly
        foreach ($orders->data as $order) {
            if ($order->status == "OPEN") {
                $orderIds[] = $order->orderid;
                $orderId = $order->orderid;
                $symbol = $order->symbol;
                $orderAction = $order->action;
                if ($type == "bid") {
                    if ($orderAction == "BUY" && $code == $symbol) {
                        $this->cancel($orderId, $symbol);
                    }
                } else if ($type == "offer" && $code == $symbol) {
                    if ($orderAction == "SELL") {
                        $this->cancel($orderId, $symbol);
                    }
                } else {
                    $this->cancel($orderId, $symbol);
                }
            }
        }

        return $orderIds;
    }

    public function beautifyOfferVolumes(Request $request, $code, $nominal)
    {
        //$this->beautifyBidVolumes($request,$code,$nominal);
        $startTime = microtime(true);  // get the current time in microseconds
        $isTest = $request->is_test;
        $isRandom = $request->is_random;
        if ($isTest == null)
            $this->cancelAllOrder("offer", $code, $nominal);
        $simulasi = [];
        $rawOrderbookResponse = $this->getOrderBook($code);
        $orderbookResponse = $rawOrderbookResponse;

        //$orderbookResponse = json_decode($this->getExampleOrderBook());

        $totalExecutedLot = 0;
        $totalExecutionExpense = 0;

        $lastprice = $orderbookResponse->data->lastprice;
        $percentChange = $orderbookResponse->data->percentage_change;
        $offer = $orderbookResponse->data->offer;
        $range = range(6, 10);  // create an array of the loop counter values

        shuffle($range);  // shufflez the array randomly

        //        if ($isRandom != false) {
        $random = $this->getRandom();
        //        $nominal = 168;
        $nominal = $random[array_rand($random)];

        //        }

        $pool = Pool::create();
        foreach ($range as $i) {
            $volumeKey = "volume$i";
            $priceKey = "price$i";
            $offerVolume = $offer->$volumeKey / 100;

            $balance = 999999999;
            if ($isTest == null) {
                $balance = $this->checkIfLotAvailable($code);
            }
            $selledLot = $this->getLotsToExecute($offerVolume, $nominal);
            $isExecuted = false;

            $price = $offer->$priceKey;

            $response = "";
            $timestamp = "";

            if ($balance > $selledLot) {
                if ($selledLot != 0) {
                    $pool->add(function () use ($selledLot, $code, $price, $isTest, &$response, &$timestamp) {
                        if ($isTest == null) {
                            do {
                                $response = json_decode($this->sell($selledLot, $code, $price));
                                $timestamp = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s.u');
                            } while (($response->data->orderid == ""));
                        }
                    });
                }
                $totalExecutedLot += $selledLot;
            }

            $executionExpense = $selledLot * $price * 100;
            $totalExecutionExpense += $executionExpense;
            $simulasi[] = (object)[
                'last_stock_price' => $lastprice,
                'last_percent_change' => $percentChange,
                'price' => $price,
                'beautify' => $nominal,
                'result' => ($offerVolume + $selledLot),
                'executed_lot' => number_format($selledLot),
                'execution_expense' => $executionExpense,
                'execution_expense_formatted' => number_format($executionExpense),
                'is_executed' => true,
                'available_lot' => number_format($offerVolume),
                'order_timestamp' => $timestamp,
                'order_response' => $response,
            ];
        }
        $pool->wait();
        $this->cancelAllOrder("bid", $code, $nominal);
        $endTime = microtime(true);  // get the current time in microseconds after the
        $elapsedTime = $endTime - $startTime;
        $result = [
            'elapsedTime' => $elapsedTime,
            'total_executed_lot' => $totalExecutedLot,
            'total_executed_lot' => $totalExecutedLot,
            'total_execution_expense' => $totalExecutionExpense,
            'total_execution_expense_formatted' => number_format($totalExecutionExpense, 2),
            'total_execution_fee' => number_format($totalExecutionExpense * 0.006, 2),
            'transaction' => $simulasi,
        ];
        return json_encode($result);
    }

    public function beautifyBidVolumes(Request $request, $code, $nominal)
    {
        $startTime = microtime(true);  // get the current time in microseconds
        $isTest = $request->is_test;
        $balance = 999999999;
        if ($isTest == null) {
            $balance = $this->getTradingBalance();
        }
        if ($isTest == null)
            $this->cancelAllOrder("bid", $code, $nominal);

        $simulasi = [];
        //        $rawOrderbookResponse = $this->getExampleOrderBook();
        $rawOrderbookResponse = $this->getOrderBook($code);
        $orderbookResponse = json_decode($rawOrderbookResponse);

        $lastprice = $orderbookResponse->data->lastprice;
        $percentChange = $orderbookResponse->data->percentage_change;
        $offer = $orderbookResponse->data->bid;
        $range = range(1, 10);  // create an array of the loop counter values
        shuffle($range);  // shufflez the array randomly

        //        $nominal = [88, 66, 44, 33, 22, 11, 99][array_rand([88, 66, 44, 33, 22, 11, 99])];
        //        $random = [77,66,55,44,33,22,11];
        $random = $this->getRandom();
        $nominal = $random[array_rand($random)];

        $totalExecutionPrice = 0;

        $pool = Pool::create();

        foreach ($range as $i) {
            $volumeKey = "volume$i";
            $priceKey = "price$i";

            $offerVolumeRaw = $offer->$volumeKey;
            if (!is_numeric($offerVolumeRaw)) {
                $offerVolumeRaw = 0;
            }
            $offerVolume = $offerVolumeRaw / 100;

            $neededLot = $this->getLotsToExecute($offerVolume, $nominal);

            $price = $offer->$priceKey;

            $response = "";
            $timestamp = "";

            if ($price != "-") {
                $isExecuted = false;
                $priceExecute = $neededLot * 100 * $price;
                if ((int)$balance > (int)$priceExecute) {
                    if ($neededLot != 0) {
                        $isExecuted = true;
                        if ($isTest == null) {
                            $pool->add(function () use ($neededLot, $code, $price, $isTest, &$response, &$timestamp) {
                                do {
                                    if ($isTest == null) {
                                        $response = json_decode($this->buy($neededLot, $code, $price));
                                        $timestamp = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s.u');
                                    }
                                } while (($response->data->orderid == ""));
                            });
                        }
                    }
                }

                $totalExecutionPrice += $priceExecute;
                $simulasi[] = (object)[
                    'last_percent_change' => $percentChange,
                    'last_stock_price' => $lastprice,
                    'price' => $price,
                    'beautify' => $nominal,
                    'availableLot' => number_format($offerVolume),
                    'result' => number_format($offerVolume + $neededLot),
                    'executedLot' => number_format($neededLot),
                    'execution_fee' => number_format($priceExecute),
                    'is_executed' => $isExecuted,
                    'order_response' => $response,
                    'order_timestamp' => $timestamp,
                    //                    'trading_balance' => $balance,
                ];
            }
        }

        $pool->wait();
        $endTime = microtime(true);  // get the current time in microseconds after the
        $elapsedTime = $endTime - $startTime;

        $result = [
            'elapsed_time' => $elapsedTime,
            'trading_balance' => number_format($balance),
            'total_execution_expense' => $totalExecutionPrice,
            'total_execution_expense_formatted' => number_format($totalExecutionPrice, 2),
            'total_execution_fee' => number_format($totalExecutionPrice * 0.006, 2),
            'transaction' => $simulasi,
        ];

        return json_encode($result);
    }

    function getLotsToExecute($lot, $arg)
    {
        if (is_nan($lot)) return 0;
        $lot = intval($lot);
        $arg = is_nan($arg) ? 0 : intval($arg);

        //ambil bagian kiri
        $left_lot = strlen((string)$lot) > strlen((string)$arg) ?
            intval(substr((string)$lot, 0, strlen((string)$lot) - strlen((string)$arg))) :
            0;

        $pick_lot = intval((intval($left_lot . $arg) > $lot ? $left_lot : $left_lot + 1) . $arg);
        return $pick_lot - $lot;
    }

    function getVolumeOnPriceOrderbook($orderbook, $price)
    {
        $volume = null;

        if (isset($orderbook['data']['bid'])) {
            $bid = $orderbook['data']['bid'];
            $priceKey = "price{$price}";
            $volumeKey = "volume{$price}";

            if (isset($bid[$priceKey]) && isset($bid[$volumeKey])) {
                $volume = $bid[$volumeKey];
            }
        }

        if (isset($orderbook['data']['offer']) && $volume === null) {
            $offer = $orderbook['data']['offer'];
            $priceKey = "price{$price}";
            $volumeKey = "volume{$price}";

            if (isset($offer[$priceKey]) && isset($offer[$volumeKey])) {
                $volume = $offer[$volumeKey];
            }
        }

        return $volume;
    }

    function getStockComposition()
    {
        // Initialize an empty array to store the composition percentages
        $raw = $this->getPortfolio();
        $portfolio = json_decode($raw);


        $composition = array();
        // Calculate the total value of the portfolio
        $totalValue = 0;
        foreach ($portfolio->data->result as $stock) {
            $totalValue += $stock->unrealised_marketvalue;
        }

        // Calculate the composition percentage and number of lots for each stock
        foreach ($portfolio->data->result as $stock) {
            $composition[] = array(
                "symbol" => $stock->symbol,
                "percentage" => round(($stock->unrealised_marketvalue / $totalValue) * 100, 2),
                "lots" => $stock->balance_lot,
                "value" => $stock->unrealised_marketvalue,
                "value_rp" => number_format($stock->unrealised_marketvalue, 2),
                "gl_percent" => round(($stock->unrealised_profitloss / $stock->amount_invested) * 100, 2),
                "gl_rupiah" => number_format($stock->unrealised_profitloss, 2)
            );
        }

        // Extract the percentage values into a separate array
        $percentages = array_column($composition, 'percentage');

        // Sort the composition data by percentage
        array_multisort($percentages, SORT_DESC, $composition);

        // Return the sorted composition data as a JSON array
        return json_encode($composition);


        // Return the composition percentages as a JSON object
        return json_encode($composition);
    }

    function getLotsToExecuteOld($volume, $beautifyArgument)
    {
        $targetNumberEnding = $beautifyArgument;
        $currentVolume = $volume;

        $difference = $targetNumberEnding - ($currentVolume % 1000);

        // If the difference is negative, it means the current volume is already greater than the target number ending
        // In this case, we need to add 1000 to the difference to get the correct number of sell positions needed
        if ($difference < 0) {
            for ($i = 0; $difference < 0; $i++) {
                $difference += 100;
            }
        }

        // Return the difference as the number of sell positions needed to reach the target number ending
        return $difference;
    }

    private function getExampleOrderBook()
    {
        return '{
    "data": {
        "average": 1449,
        "bid": {
            "price1": "1445",
            "price2": "1440",
            "price3": "1435",
            "price4": "1430",
            "price5": "1425",
            "price6": "1420",
            "price7": "1415",
            "price8": "1410",
            "price9": "1405",
            "price10": "1400",
            "que_num1": "-",
            "que_num2": "-",
            "que_num3": "-",
            "que_num4": "-",
            "que_num5": "-",
            "que_num6": "-",
            "que_num7": "-",
            "que_num8": "-",
            "que_num9": "-",
            "que_num10": "-",
            "volume1": "3300",
            "volume2": "15500",
            "volume3": "8200",
            "volume4": "19800",
            "volume5": "43200",
            "volume6": "22400",
            "volume7": "600",
            "volume8": "9500",
            "volume9": "1400",
            "volume10": "12200"
        },
        "change": 15,
        "close": 1450,
        "country": "ID",
        "domestic": "62.57",
        "down": "398",
        "exchange": "IDX",
        "fbuy": 182605000,
        "fnet": 182605000,
        "foreign": "37.43",
        "frequency": 120,
        "fsell": 0,
        "high": 1450,
        "id": "ULTJ-0",
        "lastprice": 1450,
        "low": 1435,
        "offer": {
            "price1": "1450",
            "price2": "1455",
            "price3": "1460",
            "price4": "1465",
            "price5": "1470",
            "price6": "1475",
            "price7": "1480",
            "price8": "1485",
            "price9": "1490",
            "price10": "1495",
            "que_num1": "-",
            "que_num2": "-",
            "que_num3": "-",
            "que_num4": "-",
            "que_num5": "-",
            "que_num6": "-",
            "que_num7": "-",
            "que_num8": "-",
            "que_num9": "-",
            "que_num10": "-",
            "volume1": "200",
            "volume2": "42700",
            "volume3": "51400",
            "volume4": "1600",
            "volume5": "10800",
            "volume6": "7400",
            "volume7": "900",
            "volume8": "200",
            "volume9": "5000",
            "volume10": "13700"
        },
        "open": 1435,
        "percentage_change": 1.05,
        "previous": 1435,
        "status": "Active",
        "symbol": "ULTJ",
        "symbol_2": "ULTJ",
        "symbol_3": "ULTJ",
        "tradeable": 1,
        "unchanged": "468",
        "up": "261",
        "value": 243929500,
        "volume": 168400,
        "corp_action": {
            "active": false,
            "icon": "https://assets.stockbit.com/images/corp_action_event_icon.svg",
            "text": "Perusahaan Memiliki Corporate Action"
        },
        "notation": [],
        "uma": false,
        "is_foreignbs_exist": true
    },
    "message": "Orderbook successfully created"
}';
    }
}
