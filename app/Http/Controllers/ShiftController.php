<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\ShiftKaryawan;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $jumlahHari = Carbon::createFromDate(
            $tahun,
            $bulan,
            1
        )->daysInMonth;

        $karyawan = Karyawan::where('status', 'aktif')
            ->orderBy('nama_karyawan')
            ->get();

        $shift = ShiftKaryawan::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return view(
            'shift_karyawan.index',
            compact(
                'karyawan',
                'shift',
                'bulan',
                'tahun',
                'jumlahHari'
            )
        );
    }

    public function store(Request $request)
    {
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);

        while ($mulai <= $selesai) {
            ShiftKaryawan::updateOrCreate(
                [
                    'karyawan_id' => $request->karyawan_id,
                    'tanggal' => $mulai->format('Y-m-d')
                ],
                [
                    'shift' => $request->shift
                ]
            );

            $mulai->addDay();
        }

        return back()->with(
            'success',
            'Jadwal berhasil disimpan'
        );
    }

    public function delete($id)
    {
        ShiftKaryawan::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Shift berhasil dihapus'
        );
    }
}