<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabang;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('karyawan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_jabatan = Jabatan::get();
        $data_cabang = Cabang::get();
        $data_shift = Shift::get();

        return view('karyawan.create', compact('data_jabatan', 'data_cabang', 'data_shift'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'jabatan_id' => 'required',
            'cabang_id' => 'required',
            'shift_id' => 'required',
            'gaji_pokok' => 'required',
            'lembur' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|min:6|confirmed',
        ]);

        $nama_file = "";

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_file = time() . '_' . $foto->getClientOriginalName();
            $foto->move('foto_karyawan/', $nama_file);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'foto' => $nama_file,
            'password' => bcrypt($request->password)
        ]);


        Karyawan::create([
            'users_id' => $user->id,
            'jabatan_id' => $request->jabatan_id,
            'cabang_id' => $request->cabang_id,
            'shift_id' => $request->shift_id,
            'gaji_pokok' => $request->gaji_pokok,
            'lembur' => $request->lembur
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Sukses Menambah Karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $karyawan->load(['users', 'jabatan']);
        $data_jabatan = Jabatan::get();
        $data_cabang = Cabang::get();
        $data_shift = Shift::get();

        return view('karyawan.edit', compact('karyawan', 'data_cabang', 'data_jabatan','data_shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$karyawan->users->id}",
            'jabatan_id' => 'required',
            'cabang_id' => "required",
            'shift_id' => "required",
            'gaji_pokok' => 'required|numeric',
            'lembur' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $nama_file = $karyawan->users->foto ?? ''; // Default gunakan foto lama

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($karyawan->users->foto != '') {
                unlink(public_path('foto_karyawan/' . $karyawan->users->foto));
            }

            $foto = $request->file('foto');
            $nama_file = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('foto_karyawan'), $nama_file);
        }

        // Update tabel users (relasi dengan karyawan)
        $karyawan->users()->update([
            'name' => $request->name,
            'email' => $request->email,
            'foto' => $nama_file,
        ]);

        // Update data karyawan
        $karyawan->update([
            'jabatan_id' => $request->jabatan_id,
            'cabang_id' => $request->cabang_id,
            'shift_id' => $request->shift_id,
            'gaji_pokok' => $request->gaji_pokok,
            'lembur' => $request->lembur,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Karyawan $karyawan)
    {
        // Cek apakah karyawan memiliki foto dan file tersebut ada di folder
        if ($karyawan->users && $karyawan->users->foto) {
            $path = public_path('foto_karyawan/' . $karyawan->users->foto);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        // Hapus user terkait jika ingin dihapus juga
        if ($karyawan->users) {
            $karyawan->users->delete();
        }

        // Hapus data karyawan
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }
}
