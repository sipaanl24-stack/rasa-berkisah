<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\ShiftKaryawan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        // Karyawan yang sudah memiliki jadwal pada bulan yang dipilih
        $karyawan = Karyawan::where('status', 'aktif')
            ->where('role', '!=', 'admin')
            ->whereHas('shift', function ($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun);
            })
            ->orderBy('nama_karyawan')
            ->get();

        // Semua karyawan aktif untuk dropdown Tambah Shift
        $karyawanDropdown = Karyawan::where('status', 'aktif')
            ->where('role', '!=', 'admin')
            ->orderBy('nama_karyawan')
            ->get();

        // Jadwal shift pada bulan yang dipilih
        $shift = ShiftKaryawan::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return view('shift_karyawan.index', compact(
            'karyawan',
            'karyawanDropdown',
            'shift',
            'bulan',
            'tahun',
            'jumlahHari'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'shift' => 'required|in:1,2,OFF',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);

        while ($mulai <= $selesai) {
            ShiftKaryawan::updateOrCreate(
                [
                    'karyawan_id' => $request->karyawan_id,
                    'tanggal' => $mulai->format('Y-m-d'),
                ],
                [
                    'shift' => $request->shift,
                ]
            );

            $mulai->addDay();
        }

        return back()->with('success', 'Jadwal berhasil disimpan');
    }

    public function delete($id)
    {
        ShiftKaryawan::findOrFail($id)->delete();

        return back()->with('success', 'Shift berhasil dihapus');
    }

    public function update(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'shift' => 'required|in:1,2,OFF',
            'tanggal_mulai_lama' => 'required|date',
            'tanggal_selesai_lama' => 'required|date|after_or_equal:tanggal_mulai_lama',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $karyawanId = $request->karyawan_id;

        $tanggalMulaiLama = Carbon::parse($request->tanggal_mulai_lama);
        $tanggalSelesaiLama = Carbon::parse($request->tanggal_selesai_lama);
        $tanggalMulaiBaru = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesaiBaru = Carbon::parse($request->tanggal_selesai);

        // Hapus jadwal lama
        ShiftKaryawan::where('karyawan_id', $karyawanId)
            ->whereBetween('tanggal', [
                $tanggalMulaiLama->format('Y-m-d'),
                $tanggalSelesaiLama->format('Y-m-d'),
            ])
            ->delete();

        // Buat jadwal baru
        $tanggal = $tanggalMulaiBaru->copy();

        while ($tanggal <= $tanggalSelesaiBaru) {
            ShiftKaryawan::updateOrCreate(
                [
                    'karyawan_id' => $karyawanId,
                    'tanggal' => $tanggal->format('Y-m-d'),
                ],
                [
                    'shift' => $request->shift,
                ]
            );

            $tanggal->addDay();
        }

        return back()->with('success', 'Jadwal shift berhasil diperbarui');
    }

    public function download(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        // Karyawan yang memiliki jadwal pada bulan yang dipilih
        $karyawan = Karyawan::where('status', 'aktif')
            ->where('role', '!=', 'admin')
            ->whereHas('shift', function ($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun);
            })
            ->orderBy('nama_karyawan')
            ->get();

        // Jadwal shift pada bulan yang dipilih
        $shift = ShiftKaryawan::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $namaBulan = Carbon::createFromDate(
            $tahun,
            $bulan,
            1
        )->translatedFormat('F');

        $pdf = Pdf::loadView(
            'shift_karyawan.pdf',
            compact(
                'karyawan',
                'shift',
                'bulan',
                'tahun',
                'jumlahHari',
                'namaBulan'
            )
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download(
            'jadwal-kerja-' . $namaBulan . '-' . $tahun . '.pdf'
        );
    }
}