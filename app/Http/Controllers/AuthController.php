<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Kehadiran;
use App\Models\ShiftKaryawan;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function loginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Mencari akun karyawan yang aktif
        $karyawan = Karyawan::where('email', $request->email)
            ->where('password', $request->password)
            ->where('status', 'aktif')
            ->first();

        // Jika akun tidak ditemukan atau tidak aktif
        if (!$karyawan) {
            return back()
                ->withInput()
                ->with('error', 'Email atau Password salah atau akun tidak aktif');
        }

        // Menyimpan data login ke session
        session([
            'login' => true,
            'id_karyawan' => $karyawan->id,
            'nama_karyawan' => $karyawan->nama_karyawan,
            'role' => $karyawan->role
        ]);

        // =====================================================
        // PENCATATAN KEHADIRAN BERDASARKAN SHIFT
        // =====================================================

        $sekarang = Carbon::now();

        $tanggalHariIni = $sekarang->toDateString();

        // Mencari jadwal shift karyawan hari ini
        $shiftHariIni = ShiftKaryawan::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->first();

        if ($shiftHariIni) {

            if ($shiftHariIni->shift === '1') {
                $jamMasukShift = Carbon::today()->setTime(7, 0, 0);
            } elseif ($shiftHariIni->shift === '2') {
                $jamMasukShift = Carbon::today()->setTime(15, 0, 0);
            } else {
                $jamMasukShift = null;
            }

            if ($jamMasukShift !== null) {

                $sudahAbsen = Kehadiran::where('karyawan_id', $karyawan->id)
                    ->whereDate('tanggal', $tanggalHariIni)
                    ->exists();

                if (!$sudahAbsen && $sekarang->greaterThanOrEqualTo($jamMasukShift)) {

                    $status = $sekarang->equalTo($jamMasukShift)
                        ? 'Hadir'
                        : 'Terlambat';

                    Kehadiran::create([
                        'karyawan_id' => $karyawan->id,
                        'tanggal' => $tanggalHariIni,
                        'jam_masuk' => $sekarang->format('H:i:s'),
                        'status' => $status
                    ]);
                }
            }
        }

        // =====================================================
        // REDIRECT BERDASARKAN ROLE
        // =====================================================

        if ($karyawan->role === 'admin') {
            return redirect()->route('dashboard.index');
        }

        if ($karyawan->role === 'kasir') {
            return redirect()->route('transaction.index');
        }

        if ($karyawan->role === 'kitchen') {
            return redirect()->route('pesanan.index');
        }

        // Jika role tidak dikenali
        session()->flush();

        return redirect('/login')
            ->with('error', 'Role pengguna tidak dikenali');
    }

    // Halaman welcome
    public function welcome()
    {
        // Jika belum login, kembali ke halaman login
        if (!session('login')) {
            return redirect('/login');
        }

        return view('auth.welcome');
    }

    // Proses logout
    public function logout()
    {
        // Mengambil ID karyawan dari session
        $idKaryawan = session('id_karyawan');

        // Mencari data kehadiran karyawan hari ini
        $kehadiran = Kehadiran::where('karyawan_id', $idKaryawan)
            ->whereDate('tanggal', date('Y-m-d'))
            ->first();

        // Mengisi jam keluar jika terdapat data kehadiran
        if ($kehadiran) {
            $kehadiran->update([
                'jam_keluar' => date('H:i:s')
            ]);
        }

        // Menghapus session
        session()->flush();

        return redirect('/login')
            ->with('success', 'Berhasil logout');
    }
}