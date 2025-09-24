<?php

namespace App\Http\Controllers;

use App\Models\JenisAbsensi;
use Illuminate\Http\Request;

class JenisAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jenisabsensi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenisabsensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:jenis_absensis,nama'
        ], [
            'nama.required' => 'Silahkan masukkan jenis absensi',
            'nama.unique' => 'Nama jenis absensi ini sudah ditambahkan sebelumnya'
        ]);

        JenisAbsensi::create($request->except('_method', '_token'));

        return redirect()->route('jenisabsensi.index')->with('success', 'Sukses menambahkan jenis absensi');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisAbsensi $jenisabsensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisAbsensi $jenisabsensi)
    {
        return view('jenisabsensi.edit', compact('jenisabsensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisAbsensi $jenisabsensi)
    {
        $request->validate([
            'nama' => 'required|unique:jenis_absensis,nama,' . $jenisabsensi->id,
        ], [
            'nama.required' => 'Silahkan masukkan nama jenis absensi',
            'nama.unique' => 'Nama jenis absensi ini sudah ditambahkan sebelumnya',
        ]);

        $jenisabsensi->update($request->except('_method', '_token'));

        return redirect()->route('jenisabsensi.index')->with('success', 'Sukses memperbarui jenis absensi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisAbsensi $jenisabsensi)
    {
        $jenisabsensi->delete();
        return redirect()->route('jenisabsensi.index')->with('success', 'Sukses menghapus Jenis Absensi');
    }
}
