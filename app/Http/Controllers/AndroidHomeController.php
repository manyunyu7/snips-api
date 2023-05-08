<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\BansosEvent;
use App\Models\PengajuanSKU;
use Illuminate\Http\Request;

class AndroidHomeController extends Controller
{

    public function stats()
    {

        $sisaKuota = "";
        $pengajuan = "";
        $penerima = "";

        $data = BansosEvent::orderBy('id', 'ASC')->first();

        $totalKuota = $data->kuotas;
        $pengajuan = PengajuanSKU::all()->count();
        $sisaKuota = $totalKuota - $pengajuan;

        $matchThese = ['event_id' => $data->id, 'isFinish' => 1];
        $penerima = PengajuanSKU::where($matchThese)->get()->count();

        $obj = array(
            "sisa_kuota" => $sisaKuota,
            "pengajuan" => $pengajuan,
            "penerima" => $penerima,
        );

        return RazkyFeb::responseSuccessWithData(200, 1
            , 1,
            "Success",
            "Success",
            $obj);
    }
}
