<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\DonationAccount;
use App\Models\News;
use App\Models\Sodaqo;
use App\Models\UserSodaqo;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function viewManage(Request $request, $id)
    {
        $results = $this->getResult($id, $request);
        $program = Sodaqo::findOrFail($id);
//        return $this->ddd($request);
        $programName = $program->name;
        $programTarget = $program->fundraising_target;


        $summary = (object)$this->countAndSumTransactionData($request, $results);

        $percentageFundraising = 100;
        if ($programTarget > 0)
            $percentageFundraising = (($summary->sumOfNominalNet / $programTarget) * 100);

        $neededRaw = $program->fundraising_target - $summary->sumOfNominalNet;
        $needed = "Rp." . number_format($neededRaw, 0, ".", ",");


        $datas = $results;

        return view('user_sodaqo_check.manage')->with(
            compact(
                'programName',
                'summary',
                'percentageFundraising',
                'program', 'needed'
            ));
    }

    public function getDonationsData(Request $request)
    {
        return DataTables::of($this->getDonationsDataRaw($request))->make(true);
    }

    public function getDonationsDataRaw(Request $request)
    {
        return $this->getResult($request->id, $request);
    }

    public function summaryAjax(Request $request)
    {
        $id = $request->id;
        $results = $this->getResult($id, $request);
        $summary = (object)$this->countAndSumTransactionData($request, $results);
        return $summary;
    }


    function countAndSumTransactionData(Request $request, $data)
    {
        // Create variables to hold the counts and sum
        $verifiedCount = 0;
        $waitingCount = 0;
        $invalidCount = 0;
        $sumOfNominalNet = 0;
        $totalCount = 0;
        $averageNominalNet = 0;
        $size = count($data);
        $fundraisingTarget = 0;

        $program = Sodaqo::find($request->id);
        $fee = 0;

        $accumulatedNet = 0;
        if ($program != null) {
            $fundraisingTarget = $program->fundraising_target;
            $fee = $program->admin_fee_percentage;
        }


        // Loop through the data
        foreach ($data as $record) {
            // Increment the total count
            $totalCount++;

            // Check the status value of the current record and increment the appropriate count variable
            if ($record->status === '1') {
                $verifiedCount++;
            } else if ($record->status === '0') {
                $waitingCount++;
            } else if ($record->status === '2') {
                $invalidCount++;
            } else if ($record->status === '3') {
                $verifiedCount++;
            }

            // Add the nominal_net value of the current record to the sum variable
            $sumOfNominalNet += $record->nominal_net;
        }

        if ($verifiedCount != 0) {
            // Calculate the average nominal_net value for verified transactions
            $averageNominalNet = $sumOfNominalNet / $verifiedCount;
        }

        // Format the sum of nominal_net values as a rupiah amount with 2 decimal places
        $formattedRupiah = "Rp." . number_format($sumOfNominalNet, 2, ',', '.');
        if ($fundraisingTarget>0 && $fee>0){
            $accumulatedNet = $sumOfNominalNet * (1 - ($fee / 100));
        }
        $verifiedPercentage = 0;
        $waitingPercentage = 0;
        $invalidPercentage = 0;
        $fundraisingPercentage = 0;

        if ($size > 0) {
            // Calculate the percentage of each status value in the data
            $verifiedPercentage = $verifiedCount / $totalCount * 100;
            $waitingPercentage = $waitingCount / $totalCount * 100;
            $invalidPercentage = $invalidCount / $totalCount * 100;
            if ($fundraisingTarget > 0)
                $fundraisingPercentage = $sumOfNominalNet / $fundraisingTarget * 100;
        }

        $allCount = $totalCount;


        $remaining = $sumOfNominalNet - $fundraisingTarget;
        if ($remaining < 0) {
            $remaining = "Rp." . number_format($remaining, 2, ',', '.');
        } else {
            $remaining = "(Surplus) Rp." . number_format($remaining, 2, ',', '.');
        }

        // Return an associative array containing the counts, sum, average, and percentage values
        return array(
            "fundraisingTarget" => number_format($fundraisingTarget, 2),
            "fundraisingPercentage" => $fundraisingPercentage,
            "remaining" => $remaining,
            "allCount" => $allCount,
            "verifiedCount" => $verifiedCount,
            "waitingCount" => $waitingCount,
            "invalidCount" => $invalidCount,
            "sumOfNominalNet" => $sumOfNominalNet,
            "averageNominalNet" => $averageNominalNet,
            "formattedRupiah" => $formattedRupiah,
            "verifiedPercent" => $verifiedPercentage,
            "waitingPercent" => $waitingPercentage,
            "invalidPercent" => $invalidPercentage,
            "accumulatedNet" => $accumulatedNet,
            "formattedAccumulatedNet" => number_format($accumulatedNet, 2),
            "feePercentage" => $fee,
        );
    }

    public function update(Request $request)
    {
        $obj = UserSodaqo::findOrFail($request->id);
        $obj->nominal_net = $request->nominal_net;
        if ($request->status == null) {
        } else {
            $obj->status = $request->status;
        }

        $obj->notes_admin = $request->notes;
        if ($obj->save()) {
            response()->json([
                'success' => true,
                'message' => 'Success'
            ], 500);
        } else {
            response()->json([
                'error' => false,
                'message' => 'There was an error processing your request.'
            ], 500);
        }
    }


    private function getResult($id, Request $request)
    {
        $startDate = $request->startdate;
        $endDate = $request->enddate;
        $statRaw = $request->statfilter;
        $id = $request->id;
        $statSended = "";

        if ($statRaw == "invalid"){$statSended="2";}
        if ($statRaw == "waiting"){$statSended="0";}
        if ($statRaw == "verified"){$statSended="1";}
        if ($statRaw == "verifiedw"){$statSended="3";}
        if ($statRaw == "all"){$statSended="";}


        $mymy = DB::table('user_sodaqos')
            ->select('user_sodaqos.id',
                'user_sodaqos.user_id',
                'pengguna.name as user_name',
                'pengguna.email as user_email',
                'pengguna.contact as user_contact',
                'user_sodaqos.payment_id',
                'user_sodaqos.doa',
                'user_sodaqos.nominal',
                'user_sodaqos.nominal_net',
                'user_sodaqos.notes_admin',
                'user_sodaqos.status',
                'user_sodaqos.created_at',
                // Concatenate the URL string in front of the user_sodaqos.photo column if it does not already contain a URL
                DB::raw("IF(user_sodaqos.photo NOT LIKE 'http://%' AND user_sodaqos.photo NOT LIKE 'https://%', CONCAT('http://127.0.0.1:2612', user_sodaqos.photo), user_sodaqos.photo) as payment_photo"),
                'merchant.name as payment_merchant_name',
                DB::raw("CONCAT('http://127.0.0.1:2612', merchant.photo) as payment_merchant_logo"),
                DB::raw("IF(
                (pengguna.photo NOT LIKE 'http://%' AND pengguna.photo NOT LIKE 'https://%')
                AND (pengguna.photo IS NOT NULL AND pengguna.photo != ''),
                CONCAT('http://127.0.0.1:2612', pengguna.photo),
                'https://avatar.stockbit.com/others/astro-red-toy-2-min.png' ) as user_photo"),
                'akun.name as payment_name',
                'akun.account_number as payment_number',
                DB::raw('CASE WHEN user_sodaqos.status = 0 THEN "Menunggu Verifikasi"
                                   WHEN user_sodaqos.status = 1 THEN "Pembayaran Diterima"
                                   WHEN user_sodaqos.status = 2 THEN "Pembayaran tidak valid"
                                   WHEN user_sodaqos.status = 4 THEN "Pembayaran diterima dengan catatan"
                              ELSE "Unknown" END as status_desc'),
            )
            ->leftJoin('users as pengguna', 'user_sodaqos.user_id', '=', 'pengguna.id')
            ->leftJoin('donation_accounts as akun', 'akun.id', '=', 'user_sodaqos.payment_id')
            ->leftJoin('payment_merchants as merchant', 'akun.payment_merchant_id', '=', 'merchant.id');

        if ($startDate != null && $endDate != null) {
            $mymy->whereBetween('user_sodaqos.created_at', ["$startDate", "$endDate"]);
        }
        $mymy->where("user_sodaqos.sodaqo_id", '=', $request->id);

        if ($statSended!=""){
                $mymy->where("user_sodaqos.status", '=', $statSended);
        }

        return $mymy->get();
    }

    function ddd(Request $request)
    {
        $startDate = $request->startdate;
        $endDate = $request->enddate;
        $sodaqoId = $request->id;

        $mymy = DB::table('user_sodaqos')
            ->select(DB::raw("COUNT(*) as data_count"),
                DB::raw("SUM(nominal) as nominal_sum"),
                DB::raw("SUM(nominal_net) as nominal_net_sum"),
                DB::raw("DATE_FORMAT(created_at, '%M-%Y') as month"));

        if ($startDate != null && $endDate != null) {
            $mymy->whereBetween('created_at', ["$startDate", "$endDate"]);
        }

        $mymy->where("user_sodaqos.sodaqo_id", "=", $sodaqoId)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%M-%Y')"))
            ->orderBy('created_at', 'asc');

        $mymy->where("status","=","1");

        return $mymy->get();
    }

    function groupByMonthYear($data)
    {
        // Initialize an empty associative array to store the counts
        $counts = array();

        // Loop through each item in the data
        foreach ($data as $item) {
            // Extract the month and year from the created_at field
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $item->created_at);
            $month = $date->format('m');
            $year = $date->format('Y');

            // If we haven't seen this month and year combination before,
            // initialize the count to 0
            if (!isset($counts[$month][$year])) {
                $counts[$month][$year] = 0;
            }

            // Increment the count for this month and year
            $counts[$month][$year]++;
        }

        // Return the counts
        return $counts;
    }


}
