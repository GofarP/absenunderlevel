<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gaji;
use App\Models\Absensi;
use App\Models\JenisAbsensi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StatusAbsensi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sudah_absen = Absensi::where('users_id', Auth::user()->id)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        return view('absensi.index', compact('sudah_absen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_status_absensi = StatusAbsensi::get();
        $data_jenis_absensi=JenisAbsensi::get();
        return view('absensi.create', compact('data_status_absensi','data_jenis_absensi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status_absensi_id' => 'required',
            'jenis_absensi_id'=>'required',
        ], [
            'status_absensi_id.required' => 'Silahkan Pilih Status Masuk',
            'jenis_absensi_id.required'=>'Silahkan Pilih Jenis Absensi'
        ]);
        $user_name = Str::slug(Auth::user()->name); // ganti spasi jadi strip
        $today = now()->format('d-m-Y');

        $folder_path = public_path('foto_absensi/');
        File::ensureDirectoryExists($folder_path);

        $image_parts = explode(";base64,", $request->foto);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1]; // misal: png, jpeg

        $image_base64 = base64_decode($image_parts[1]);

        // Buat file sementara
        $tmp_file = tempnam(sys_get_temp_dir(), 'foto_absen_');
        file_put_contents($tmp_file, $image_base64);

        // Buat nama file akhir
        $file_name = "{$user_name}-{$today}." . $image_type;

        // Pindahkan file sementara ke folder tujuan
        $destination_path = $folder_path . $file_name;
        File::move($tmp_file, $destination_path);

        $absensi = Absensi::create([
            'users_id' => Auth::user()->id,
            'status_absensi_id' => $request->status_absensi_id,
            'jenis_absensi_id'=>$request->jenis_absensi_id,
            'shift_id' => Auth::user()->karyawan->first()?->shift_id,
            'foto' => $file_name
        ]);

        $jumlah_hari = \Carbon\Carbon::now()->daysInMonth();
        $gaji_harian = Auth::user()->karyawan->first()?->gaji_pokok / $jumlah_hari;

        // $lembur = 0;

        // if ($request->lembur == 1) {
        //     $lembur = Auth::user()->karyawan->first()?->lembur;
        // }
        // Gaji::create([
        //     'karyawan_id' => Auth::user()->id,
        //     'absensi_id' => $absensi->id,
        //     'gaji_harian' => $gaji_harian,
        //     'lembur' => $lembur,
        // ]);

        return redirect()->route('absensi.index')->with('success', 'Sukses Absensi Untuk Hari Ini');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        $gaji = Gaji::where('absensi_id', $absensi->id)->first();
        return view('absensi.edit', compact('absensi', 'gaji'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'created_at' => 'required'
        ], [
            'created_at.required' => 'Silahkan Masukkan Jam Masuk'
        ]);

        $lembur = 0;
        if ($request->lembur == 1) {
            $lembur = Auth::user()->karyawan->lembur;
        }

        $absensi->update();

        Gaji::where('absensi_id', $absensi->id)->update(['lembur' => $lembur]);

        return redirect()->route('absensi.index')->with('success', 'Sukses mengubah absensi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        Gaji::where('absensi_id', $absensi->id)->delete();
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Sukses Menghapus Data Absensi');
    }

    public function  laporanAbsensi()
    {
        return view('absensi.laporanabsensi');
    }

    public function print(Request $request)
    {

        $mulai_dari = Carbon::parse($request->mulai_dari)->startOfDay();
        $sampai_dengan = Carbon::parse($request->sampai_dengan)->endOfDay();

        $data_laporan_absensi = Absensi::whereBetween('created_at', [$mulai_dari, $sampai_dengan])
            ->get();

        return view('absensi.print', compact('data_laporan_absensi', 'mulai_dari', 'sampai_dengan'));
    }
}
