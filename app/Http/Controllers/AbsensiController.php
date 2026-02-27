<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Cabang;
use App\Models\JenisAbsensi;
use App\Models\Karyawan;
use App\Models\StatusAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hariIni = now()->toDateString();
        $userId = Auth::id();
        $riwayatHariIni = Absensi::where('users_id', $userId)
            ->whereDate('created_at', $hariIni)
            ->get();
        $cekAbsenMasuk = $riwayatHariIni->where('jenis_absensi_id', 1)->first();

        $cekAbsenKeluar = $riwayatHariIni->where('jenis_absensi_id', 2)->first();

        return view('absensi.index', compact('cekAbsenMasuk', 'cekAbsenKeluar'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataStatusAbsensi = StatusAbsensi::get();
        $dataJenisAbsensi = JenisAbsensi::get();
        $cabangKaryawan = Auth::user()->karyawan->first()->cabang_id;
        $cabang = Cabang::where('id', $cabangKaryawan)->first();

        return view('absensi.create', compact('dataStatusAbsensi', 'dataJenisAbsensi', 'cabang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'status_absensi_id' => 'required',
            'jenis_absensi_id' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'foto' => 'required',
        ], [
            'status_absensi_id.required' => 'Silahkan Pilih Status Masuk',
            'jenis_absensi_id.required' => 'Silahkan Pilih Jenis Absensi',
            'lat.required' => 'Lokasi tidak terdeteksi. Pastikan GPS aktif.',
            'lng.required' => 'Lokasi tidak terdeteksi. Pastikan GPS aktif.',
        ]);

        $user = Auth::user();

        // 2. PERBAIKAN UTAMA: Ambil Karyawan Menggunakan Query Manual (first)
        // Ini solusi anti-error "Collection"
        $karyawan = Karyawan::where('users_id', $user->id)->first();

        // 3. Cek Ketersediaan Data Karyawan
        if (!$karyawan) {
            return back()->with('error', 'Akun Anda belum terdaftar sebagai data Karyawan.');
        }

        // 4. Ambil Cabang dari Karyawan tersebut
        $cabang = $karyawan->cabang;

        if (!$cabang) {
            return back()->with('error', 'Data lokasi kantor (Cabang) belum diatur untuk Anda.');
        }

        // 5. Hitung Jarak (Geofencing)
        // Pastikan ejaan 'lattitude' (double t) atau 'latitude' (satu t) sesuai database Anda!
        $jarakMeter = $this->countGeofencingRange(
            $request->lat,
            $request->lng,
            $cabang->lattitude,
            $cabang->longitude
        );

        $maxRadius = 100; // Radius dalam meter

        if ($jarakMeter > $maxRadius) {
            return back()->with('error', "Gagal Absen! Jarak Anda: " . round($jarakMeter) . " meter (Maks: $maxRadius m). Silahkan absen di area kantor.");
        }

        // 6. Proses Gambar
        $user_name = Str::slug($user->name);
        $today = now()->format('d-m-Y-H-i-s');
        $folder_path = public_path('foto_absensi/');

        File::ensureDirectoryExists($folder_path);

        if (preg_match('/^data:image\/(\w+);base64,/', $request->foto, $type)) {
            $image_type = strtolower($type[1]);

            if (!in_array($image_type, ['jpg', 'jpeg', 'png'])) {
                return back()->with('error', 'Format gambar harus jpg, jpeg, atau png.');
            }

            $image_parts = explode(',', $request->foto);
            $image_base64 = base64_decode($image_parts[1]);
            $file_name = "{$user_name}-{$today}.{$image_type}";

            file_put_contents($folder_path . $file_name, $image_base64);
        } else {
            return back()->with('error', 'File foto korup atau tidak valid.');
        }

        // 7. Simpan Absensi
        $absensi = Absensi::create([
            'users_id' => $user->id,
            'status_absensi_id' => $request->status_absensi_id,
            'jenis_absensi_id' => $request->jenis_absensi_id,
            'shift_id' => $karyawan->shift_id,
            'foto' => $file_name,
            'lembur' => $request->lembur,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
        ]);

        return redirect()->route('absensi.index')->with('success', 'Sukses Absensi! Jarak: ' . round($jarakMeter) . 'm');
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
        return view('absensi.edit', compact('absensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'lembur' => 'required',
        ]);

        $absensi->update([
            'lembur' => $request->lembur,
        ]);

        return redirect()->route('absensi.index')->with('success', 'Sukses mengubah absensi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Sukses Menghapus Data Absensi');
    }

    public function laporanAbsensi()
    {
        $jenisAbsensis = JenisAbsensi::get();

        return view('absensi.laporanabsensi', compact('jenisAbsensis'));
    }

    public function print(Request $request)
    {

        $mulai_dari = Carbon::parse($request->mulai_dari)->startOfDay();
        $sampai_dengan = Carbon::parse($request->sampai_dengan)->endOfDay();
        $jenis_absensi_id = $request->jenis_absensi_id;

        $data_laporan_absensi = Absensi::with('jenisabsensi')
            ->whereBetween('created_at', [$mulai_dari, $sampai_dengan])
            ->when($jenis_absensi_id && $jenis_absensi_id !== 'semua', function ($query) use ($jenis_absensi_id) {
                return $query->where('jenis_absensi_id', $jenis_absensi_id);
            })
            ->get();

        return view('absensi.print', compact('data_laporan_absensi', 'mulai_dari', 'sampai_dengan'));
    }

    private function countGeofencingRange($userLat, $userLng, $targetLat, $targetLng)
    {
        $earthRadiusKm = 6371;

        $latitudeDifference = deg2rad($targetLat - $userLat);
        $longitudeDifference = deg2rad($targetLng - $userLng);

        $sinHalfLat = sin($latitudeDifference / 2);
        $sinHalfLng = sin($longitudeDifference / 2);

        $squareOfHalfChordLength = ($sinHalfLat * $sinHalfLat) +
            cos(deg2rad($userLat)) * cos(deg2rad($targetLat)) *
            ($sinHalfLng * $sinHalfLng);

        $angularDistance = 2 * atan2(
            sqrt($squareOfHalfChordLength),
            sqrt(1 - $squareOfHalfChordLength)
        );

        $distanceInKm = $earthRadiusKm * $angularDistance;

        return round($distanceInKm * 1000);
    }
}
