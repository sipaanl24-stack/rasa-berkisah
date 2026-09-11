<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();

        return view('karyawan.index', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $karyawanTerakhir = Karyawan::latest('id')->first();

        $nomor = $karyawanTerakhir
            ? $karyawanTerakhir->id + 1
            : 1;

        $kode = 'KRY' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        Karyawan::create([
            'kode_karyawan' => $kode,
            'nama_karyawan' => $request->nama_karyawan,
            'email'          => $request->email,
            'password'       => $request->password,
            'role'           => $request->role,
            'status'         => $request->status,
            'kontak'         => $request->kontak,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->update([
            'kode_karyawan' => $request->kode_karyawan,
            'nama_karyawan' => $request->nama_karyawan,
            'email'          => $request->email,
            'role'           => $request->role,
            'status'         => $request->status,
            'kontak'         => $request->kontak,
        ]);

        if ($request->filled('password')) {
            $karyawan->update([
                'password' => $request->password
            ]);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();

        return redirect()->back();
    }
}