<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:jabatans,nama'
        ], [
            'nama.required' => 'Silahkan masukkan nama jabatan',
            'nama.unique' => 'Nama jabatan ini sudah ditambahkan sebelumnya'
        ]);

        Jabatan::create($request->except('_method', '_token'));

        return redirect()->route('jabatan.index')->with('success', 'Sukses menambahkan jabatan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama' => 'required|unique:jabatans,nama,' . $jabatan->id,
        ], [
            'nama.required' => 'Silahkan masukkan nama jabatan',
            'nama.unique' => 'Nama jabatan ini sudah ditambahkan sebelumnya',
        ]);

        $jabatan->update($request->except('_method', '_token'));

        return redirect()->route('jabatan.index')->with('success', 'Sukses memperbarui jabatan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success','Sukses menghapus jabatan');
    }
}
