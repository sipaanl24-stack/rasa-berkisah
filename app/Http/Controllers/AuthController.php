<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Kehadiran;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $karyawan = Karyawan::where('email', $request->email)
                    ->where('password', $request->password)
                    ->first();

        if (!$karyawan)
        {
            return back()->with('error', 'Email atau Password salah');
        }

        session([
            'login' => true,
            'id_karyawan' => $karyawan->id,
            'nama_karyawan' => $karyawan->nama_karyawan,
            'role' => $karyawan->role
        ]);

        Kehadiran::create([
            'karyawan_id' => $karyawan->id,
            'tanggal' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
            'status' => 'Hadir'
        ]);

        return redirect('/welcome');
    }

    public function welcome()
    {
        if (!session('login'))
        {
            return redirect('/login');
        }

        return view('auth.welcome');
    }

    public function logout()
    {
        $idKaryawan = session('id_karyawan');

        $kehadiran = Kehadiran::where('karyawan_id', $idKaryawan)
                    ->whereDate('tanggal', date('Y-m-d'))
                    ->latest()
                    ->first();

        if ($kehadiran)
        {
            $kehadiran->update([
                'jam_keluar' => date('H:i:s')
            ]);
        }

        session()->flush();

        return redirect('/login')
                ->with('success', 'Berhasil logout');
    }
}

?>