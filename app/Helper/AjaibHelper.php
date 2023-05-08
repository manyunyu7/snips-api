<?php

namespace App\Helper;


use App\Models\UserMNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AjaibHelper
{

    public static function generateBearer()
    {
        return "jwt " .
            "eyJ0eXAiOiJBQ0NFU1MiLCJhbGciOiJFUzUxMiJ9.eyJhamFpYiI6IjM3MTEzNDguV0VCLkFDQ0VTUyIsInBsYXRmb3JtIjoiV0VCIiwiYXVkIjoiaHR0cHM6Ly9hcHAuYWphaWIuY28uaWQiLCJleHAiOjE2NzIwMTgxMTksImp0aSI6IjE1NDAwYzQzLTcyNWYtNGI0NS1iYzRkLTFkNWIzMmJmYTM5YiIsImlzcyI6Imh0dHBzOi8vYXBwLmFqYWliLmNvLmlkIiwiaWF0IjoxNjcyMDE3MjE5LCJzdWIiOiIzNzExMzQ4In0.AGV9naf1gVaBM7BrsdD6JVb34hX3IdpeGF7CXA_cUJLTna640PLx2lapZqlcCejFnsIcvQR8E6aKGPJqxSBbRFF3AD2QZABs2WeWyGzU6uDXNdSLJnn74ntE3BQ7Q_LwfdMUMtfrWKMTr-dOmB7aF0nPCboOaqw0p7paHQFzi06iAqmJ"
            ;
    }

    public static function getTradeHeader()
    {
        return [
            'accept' => '*/*',
            'accept-language' => 'id',
            'Authorization' => self::generateBearer(),
            'content-type' => 'application/json',
            'sec-ch-ua' => '"Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
            'sec-ch-ua-mobile' => '?1',
            'sec-ch-ua-platform' => '"Android"',
            'sec-fetch-dest' => 'empty',
            'sec-fetch-mode' => 'cors',
            'sec-fetch-site' => 'same-site',
            'x-ht-ver-id' => 'f2748e0bee5b22f823084e591bcb5d75766431a7738b854668729b54def0452276ff13450b8723657e80756c861c802c750e6515f0e1017783d66e2947a2356f',
            'x-platform' => 'WEB',
            'x-product' => 'stock-mf',
            'Referer' => 'https://invest.ajaib.co.id/',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
        ];
    }


}



