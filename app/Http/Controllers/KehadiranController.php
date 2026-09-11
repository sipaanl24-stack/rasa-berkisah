<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    /**
     * ==========================================
     * HALAMAN KEHADIRAN
     * ==========================================
     */
    public function index(Request $request)
    {
        $query = Kehadiran::join(
            'karyawan',
            'karyawan.id',
            '=',
            'kehadiran.karyawan_id'
        )
        ->select(
            'kehadiran.*',
            'karyawan.nama_karyawan',
            'karyawan.role'
        )
        ->where('karyawan.role', '!=', 'admin');

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate(
                'kehadiran.tanggal',
                $request->tanggal
            );
        }

        // Data terbaru
        $data = $query
            ->orderBy('kehadiran.tanggal', 'desc')
            ->orderBy('kehadiran.jam_masuk', 'desc')
            ->paginate(
                7,
                ['*'],
                'kehadiran_page'
            )
            ->withQueryString();

        return view(
            'kehadiran.index',
            compact('data')
        );
    }


    /**
     * ==========================================
     * HALAMAN REKAP KEHADIRAN
     * ==========================================
     */
    public function rekap(Request $request)
    {
        $query = Kehadiran::join(
            'karyawan',
            'karyawan.id',
            '=',
            'kehadiran.karyawan_id'
        )
        ->select(
            'kehadiran.*',
            'karyawan.nama_karyawan',
            'karyawan.role'
        )
        ->where('karyawan.role', '!=', 'admin');

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate(
                'kehadiran.tanggal',
                $request->tanggal
            );
        }

        // Data terbaru
        $jamKerja = $query
            ->orderBy('kehadiran.tanggal', 'desc')
            ->orderBy('kehadiran.jam_masuk', 'desc')
            ->get();

        // ==========================================
        // HITUNG TOTAL JAM KERJA
        // ==========================================
        foreach ($jamKerja as $item) {

            if ($item->jam_masuk && $item->jam_keluar) {

                $masuk = Carbon::parse($item->jam_masuk);
                $keluar = Carbon::parse($item->jam_keluar);

                $totalMenit = $masuk->diffInMinutes($keluar);

                $item->total_jam = intdiv(
                    $totalMenit,
                    60
                );

                $item->total_menit = $totalMenit % 60;

            } else {

                $item->total_jam = null;
                $item->total_menit = null;
            }
        }

        return view(
            'kehadiran.rekap',
            compact('jamKerja')
        );
    }
}