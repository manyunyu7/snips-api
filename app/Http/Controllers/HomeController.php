<?php

namespace App\Http\Controllers;

use App\Models\BansosEvent;
use App\Models\PengajuanSKU;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        return redirect('/admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            return redirect('/admin');
        }
        if (Auth::user()->role == 3) {
            return redirect('/user');
        }
        if (Auth::user()->role == 4) {
            return redirect('/kelurahan');
        }
        if (Auth::user()->role == 5) {
            return redirect('/kecamatan');
        }
        return redirect('/admin');
    }

    public function admin()
    {
        $datas = $this->getSodaqosManage();
//        return $datas;
        return view('sodaqo.manage')->with(compact('datas'));
//        return view('home.admin');
    }

    public function kelurahan()
    {
        return view('home.admin');
    }

    public function kecamatan()
    {
        return view('home.admin');
    }

    public function user()
    {
        return view('home.user');
    }

    private function getSodaqosManage()
    {
        $search = "";
        $start_date = "";
        $end_date = "";
        $results = DB::table('sodaqos as s')
            ->leftJoin('user_sodaqos as u', 's.id', '=', 'u.sodaqo_id')
            ->leftJoin('users as u2', 's.owner_id', '=', 'u2.id')
            ->leftJoin('sodaqo_categories as c', 's.category_id', '=', 'c.id')
            ->select(
                's.*',
                'u2.name as creator_name',
                'u2.photo as creator_photo',
                'c.name as sodaqo_category_name',
                DB::raw('SUM(u.nominal) as total_nominal'),
                DB::raw('SUM(u.nominal_net) as total_nominal_net'),
                DB::raw('COUNT(u.id) as transaction_count'),
            )
            ->where("s.owner_id", '=', Auth::id())
            ->whereNull('s.is_deleted');

        if ($search != '') {
            $results = $results->where(function ($query) use ($search) {
                $query->orWhere('s.name', 'like', '%' . $search . '%');
                $query->orWhere('s.description', 'like', '%' . $search . '%');
                $query->orWhere('s.created_at', 'like', '%' . $search . '%');
                $query->orWhere('u2.name', 'like', '%' . $search . '%');
                $query->orWhere('c.name', 'like', '%' . $search . '%');
            });
        }

        if ($start_date != '') {
            $results = $results->where('s.created_at', '>=', $start_date);
        }

        if ($end_date != '') {
            $results = $results->where('s.created_at', '<=', $end_date);
        }

        $results = $results->groupBy('s.id')->get()
            ->map(function ($item) {
                $item->total_nominal = (double)$item->total_nominal;
                $item->total_nominal_net = (double)$item->total_nominal;
                $item->total_nominal_formatted = 'Rp ' . number_format($item->total_nominal, 2, ',', '.');
                $item->total_nominal_net_formatted = 'Rp ' . number_format($item->total_nominal_net, 2, ',', '.');
                $item->fundraising_target_formatted = 'Rp ' . number_format($item->fundraising_target, 2, ',', '.');

                $item->story = "";
                $item->photo_path = strpos($item->photo, 'http') === false ? url('/') . $item->photo : $item->photo;
                $item->creator_photo_path = strpos($item->creator_photo, 'http') === false ? url('/') . $item->creator_photo : $item->creator_photo;


                $item->remaining_time = Carbon::parse($item->time_limit)->diffInDays(Carbon::now());
                Carbon::setLocale('id');
                $item->remaining_time_desc =
                $diff = Carbon::now()->diffForHumans(Carbon::parse($item->time_limit), true,);
                return $item;
            });

        return $results;
    }


}
