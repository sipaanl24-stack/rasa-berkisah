<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;

class KehadiranController extends Controller
{
    public function index()
    {
            $data = Kehadiran::join(
            'karyawan',
            'karyawan.id',
            '=',
            'kehadiran.karyawan_id'
        )
        ->select(
            'kehadiran.*',
            'karyawan.nama_karyawan'
        )
        ->latest()
        ->paginate(7);

        return view('kehadiran.index',compact('data'));
    }
}