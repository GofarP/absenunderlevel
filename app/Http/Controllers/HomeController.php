<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gaji;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user_id = Auth::id();

        $bulan_ini = Carbon::now();
        $bulan_lalu = $bulan_ini->copy()->subMonth();

        $data_bulan_ini = $this->getDataBulanan($bulan_ini, $user_id);
        $data_bulan_lalu = $this->getDataBulanan($bulan_lalu, $user_id);


        return view('dashboard.index', [
            'jumlah_masuk_bulan_ini' => $data_bulan_ini['masuk'],

            'jumlah_masuk_bulan_lalu' => $data_bulan_lalu['masuk'],
        ]);
    }

    private function getDataBulanan($tanggal, $user_id)
    {
        return [
            'masuk' => Absensi::where('users_id', $user_id)
                ->whereMonth('created_at', $tanggal->month)
                ->whereYear('created_at', $tanggal->year)
                ->count(),

        ];
    }
}
