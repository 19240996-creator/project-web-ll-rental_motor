<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index()
    {
        $motors = Motor::all();
        return view('motor.index', compact('motors'));
    }

    public function create()
    {
        return view('motor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_motor' => 'required|unique:motor,Id_motor',
            'Merk_motor' => 'required',
            'Warna_motor' => 'required',
            'Plat_nomor' => 'required|unique:motor,Plat_nomor',
            'Tahun_motor' => 'required',
            'Harga' => 'required|numeric',
        ]);

        Motor::create($request->all());

        return redirect()->route('motor.index')->with('success', 'Motor berhasil ditambahkan');
    }

    public function show(Motor $motor)
    {
        return view('motor.show', compact('motor'));
    }

    public function edit(Motor $motor)
    {
        return view('motor.edit', compact('motor'));
    }

    public function update(Request $request, Motor $motor)
    {
        $request->validate([
            'Merk_motor' => 'required',
            'Warna_motor' => 'required',
            'Tahun_motor' => 'required',
            'Harga' => 'required|numeric',
        ]);

        $motor->update($request->all());

        return redirect()->route('motor.index')->with('success', 'Motor berhasil diperbarui');
    }

    public function destroy(Motor $motor)
    {
        $motor->delete();

        return redirect()->route('motor.index')->with('success', 'Motor berhasil dihapus');
    }
}

