<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class PesananController extends Controller
{
public function index()
{
    $pesanan = Transaksi::with([
            'detail.menu',
            'meja'
        ])
        ->where('status', 'pending')
        ->orderBy('created_at', 'asc')
        ->get();

    $riwayat = Transaksi::with([
            'detail.menu',
            'meja'
        ])
        ->where('status', 'selesai')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pesanan.index', compact(
        'pesanan',
        'riwayat'
    ));
}

    public function selesai($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'status' => 'selesai'
        ]);

        return back()->with('success', 'Pesanan telah selesai.');
    }
}