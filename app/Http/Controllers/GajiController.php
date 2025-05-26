<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Gaji $gaji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gaji $gaji)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gaji $gaji)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gaji $gaji)
    {
        //
    }

    public function laporanGaji()
    {
        return view('gaji.laporangaji');
    }

    public function print(Request $request)
    {
        $mulai_dari = \Carbon\Carbon::parse($request->mulai_dari)->startOfDay();
        $sampai_dengan = \Carbon\Carbon::parse($request->sampai_dengan)->endOfDay();

        $data_laporan_gaji=Gaji::with('karyawan')
        ->whereBetween('created_at',[$mulai_dari,$sampai_dengan])
        ->get();

        return view('gaji.print',compact('data_laporan_gaji','mulai_dari','sampai_dengan'));
    }
}
