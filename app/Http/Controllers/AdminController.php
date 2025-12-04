<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_admin_rental_motor' => 'required|unique:admin_sewa_motor,Id_admin_rental_motor',
            'Nama_admin' => 'required',
            'Alamat' => 'required',
            'No_telp' => 'required',
        ]);

        Admin::create($request->all());

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function show(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'Nama_admin' => 'required',
            'Alamat' => 'required',
            'No_telp' => 'required',
        ]);

        $admin->update($request->all());

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
    }
}
