<?php

namespace App\Http\Controllers;

use App\Models\StatusAbsensi;
use Illuminate\Http\Request;

class StatusAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('statusabsensi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('statusabsensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => "required|unique:status_absensis,nama,"
        ]);

        StatusAbsensi::create($request->except('_method', '_token'));

        return redirect()->route('statusabsensi.index')->with('success', 'Sukses Mebambah Status Absensi');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusAbsensi $statusAbsensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusAbsensi $statusabsensi)
    {
        return view('statusabsensi.edit', compact('statusabsensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusAbsensi $statusabsensi)
    {
        $request->validate([
            'nama' => "required|unique:status_absensis,nama," . $statusabsensi->id
        ]);

        $statusabsensi->update();

        return redirect()->route('statusabsensi.index')->with('success', 'Sukses Mengubah Status Absensi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusAbsensi $statusabsensi)
    {
        $statusabsensi->delete();
        return redirect()->route('statusabsensi.index')->with('success', 'Sukses Menghapus Status Absensi');
    }
}
