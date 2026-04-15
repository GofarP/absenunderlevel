<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\JenisAbsensi;
use App\Models\Karyawan;
use App\Models\StatusAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

        return view('absensi.create', compact('dataStatusAbsensi', 'dataJenisAbsensi'));
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
            'foto' => 'required', // String Base64 dari kamera
        ], [
            'status_absensi_id.required' => 'Silahkan Pilih Status Masuk',
            'jenis_absensi_id.required' => 'Silahkan Pilih Jenis Absensi',
            'lat.required' => 'Lokasi tidak terdeteksi. Pastikan GPS aktif.',
            'lng.required' => 'Lokasi tidak terdeteksi. Pastikan GPS aktif.',
        ]);

        $user = Auth::user();

        // 2. Ambil Data Karyawan
        $karyawan = Karyawan::where('users_id', $user->id)->first();

        if (!$karyawan) {
            return back()->with('error', 'Akun Anda belum terdaftar sebagai data Karyawan.');
        }

        // 3. Cek Geofencing (Jarak)
        $kantorLat = 0.910061;
        $kantorLng = 104.476578;

        $jarakMeter = $this->countGeofencingRange($request->lat, $request->lng, $kantorLat, $kantorLng);
        $maxRadius = 100;

        if ($jarakMeter > $maxRadius) {
            return back()->with('error', "Gagal! Anda berada di luar radius (" . round($jarakMeter) . "m).");
        }

        // 4. Proses Gambar Base64 (Sama mudahnya dengan move file)
        $file_name = null;
        if (preg_match('/^data:image\/(\w+);base64,/', $request->foto, $type)) {
            $image_type = strtolower($type[1]); // jpg, png, jpeg

            if (!in_array($image_type, ['jpg', 'jpeg', 'png'])) {
                return back()->with('error', 'Format gambar harus jpg, jpeg, atau png.');
            }

            $image_base64 = base64_decode(explode(',', $request->foto)[1]);

            // Penamaan file mirip style foto karyawan
            $user_name = Str::slug($user->name);
            $timestamp = now()->format('d-m-Y-H-i-s');
            $file_name = "{$user_name}-{$timestamp}.{$image_type}";

            // Tentukan path ke folder PUBLIC (Bukan Storage)
            $folder_path = public_path('foto_absensi/');

            // Buat folder jika belum ada (mirip mkdir)
            if (!File::exists($folder_path)) {
                File::makeDirectory($folder_path, 0755, true);
            }

            // Tulis file ke folder tersebut
            file_put_contents($folder_path . $file_name, $image_base64);

            // KRUSIAL: Ubah permission agar bisa dilihat browser (Fix Forbidden)
            chmod($folder_path . $file_name, 0644);

        } else {
            return back()->with('error', 'File foto tidak valid.');
        }

        // 5. Simpan ke Database
        Absensi::create([
            'users_id' => $user->id,
            'status_absensi_id' => $request->status_absensi_id,
            'jenis_absensi_id' => $request->jenis_absensi_id,
            'shift_id' => $karyawan->shift_id,
            'foto' => $file_name,
            'lembur' => $request->lembur ?? 0,
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
