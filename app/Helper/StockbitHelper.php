<?php

namespace App\Helper;


use App\Models\UserMNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StockbitHelper
{

    public static function getBearerTokenTrade()
    {
        return "Bearer " .
        "eyJhbGciOiJIUzI1NiIsImtpZCI6InNpbTMifQ.eyJhdWQiOiJodHRwczovL3N0b2NrYml0LmNvbSIsImRhdGEiOnsiYWNjX2lkIjozNDI4MTMsImFjY19ubyI6IjAwODA5OTAiLCJicm9rZXJfbmFtZSI6IlN0b2NrYml0IiwiY2NvZGUiOiIwMDgwOTkwIiwicGxhIjoiUEMiLCJzYl9pZCI6OTc5MjE1LCJzYnVzZSI6ImhlbnJ5YXVndXN0YSIsInNjIjoiMSIsInNpZCI6ImE0NTY5YmFhLTk3MWItNDZkNi1iNTdmLTMzYWIwZGYyZmYzMiIsInVzZSI6ImhlbnJ5YXVndXN0YSJ9LCJleHAiOjE2Nzk2NTU5MjcsImlzcyI6IlNUT0NLQklUIiwianRpIjoibW1kSzhLKzNLZkE9In0.2rtvhoVHEa81FSXXEcimckaPpZnf1ryIFOjx1KBlayM"
        . "";
    }

    public static function getBearerToken()
    {
        return "Bearer " .
            "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZSI6ImhlbnJ5YXVndXN0YSIsImVtYSI6ImhlbnJ5YXVndXN0YTRAZ21haWwuY29tIiwiZnVsIjoiSGVucnkgQXVndXN0YSIsInNlcyI6ImJDbjg4cnV4dWtCckRXQ0giLCJkdmMiOiIiLCJ1aWQiOjk3OTIxNX0sImV4cCI6MTY4MjgyMTg0MiwianRpIjoiM2U4ODQ1NzktMGY3Zi00M2VlLWEwOTMtMzI4MWRlNjRlYjIxIiwiaWF0IjoxNjgyNzM1NDQyLCJpc3MiOiJTVE9DS0JJVCIsIm5iZiI6MTY4MjczNTQ0Mn0.BW2cZhLLUmPykl1-xgK2mXunMwwL-XS7v5eo1Xw6rpQ"
            . "";
    }
}
