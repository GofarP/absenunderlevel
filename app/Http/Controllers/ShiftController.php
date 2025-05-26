<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shift.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shift.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:shifts,nama,',
            'mulai_dari' => 'required',
            'sampai_dengan' => 'required'
        ], [
            'nama.required' => 'Silahkan Masukkan Nama Shift',
            'nama.unique' => 'Nama Shift sudah ditambahkan sebelumnya',
            'mulai_dari.required' => 'Silahkan Masukkan Jam Mulai Shift',
            'sampai_dengan.required' => 'Silahkan Masukkan Jam Selesai Shift'
        ]);

        Shift::create($request->except('_method', '_token'));

        return redirect()->route('shift.index')->with('success', 'Sukses Menambah Shift');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        return view('shift.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'nama' => 'required|unique:shifts,nama,'.$shift->id,
            'mulai_dari' => 'required',
            'sampai_dengan' => 'required'
        ], [
            'nama.required' => 'Silahkan Masukkan Nama Shift',
            'nama.unique' => 'Nama Shift sudah ditambahkan sebelumnya',
            'mulai_dari.required' => 'Silahkan Masukkan Jam Mulai Shift',
            'sampai_dengan.required' => 'Silahkan Masukkan Jam Selesai Shift'
        ]);


        $shift->update();

        return redirect()->route('shift.index')->with('success', 'Sukses Mengubah Shift');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('shift.index')->with('success','Sukses Menghapus Shift');
    }
}
