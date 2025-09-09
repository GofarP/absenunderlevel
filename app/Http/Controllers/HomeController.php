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

        $total_gaji_bulan_ini = $data_bulan_ini['gaji_harian'] + $data_bulan_ini['lembur'];

        $total_gaji_bulan_lalu=$data_bulan_lalu['gaji_harian'] + $data_bulan_lalu['lembur'];

        return view('dashboard.index', [
            'jumlah_masuk_bulan_ini' => $data_bulan_ini['masuk'],
            'jumlah_lembur_bulan_ini' => $data_bulan_ini['jumlah_lembur'],

            'jumlah_masuk_bulan_lalu' => $data_bulan_lalu['masuk'],
            'jumlah_lembur_bulan_lalu' => $data_bulan_lalu['jumlah_lembur'],
        ]);
    }

    private function getDataBulanan($tanggal, $user_id)
    {
        return [
            'masuk' => Absensi::where('users_id', $user_id)
                ->whereMonth('created_at', $tanggal->month)
                ->whereYear('created_at', $tanggal->year)
                ->count(),

            'jumlah_lembur' => Gaji::where('lembur', '>', 0)
                ->whereMonth('created_at', $tanggal->month)
                ->whereYear('created_at', $tanggal->year)
                ->count(),

            'gaji_harian' => Gaji::whereMonth('created_at', $tanggal->month)
                ->whereYear('created_at', $tanggal->year)
                ->sum('gaji_harian'),

            'lembur' => Gaji::whereMonth('created_at', $tanggal->month)
                ->whereYear('created_at', $tanggal->year)
                ->sum('lembur'),
        ];
    }
}
