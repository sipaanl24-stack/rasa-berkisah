<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Jurnal;
use App\Models\MenuMakanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
public function index(Request $request, $id = null)
{
    $menu = MenuMakanan::all();

    $transaksi = null;
    $mejaId = null;

    if ($id) {
        $transaksiById = Transaksi::with([
                'detail.menu',
                'meja'
            ])
            ->find($id);

        if ($transaksiById) {
            $transaksi = $transaksiById;
            $mejaId = $transaksiById->meja_id;
        } else {
            $mejaId = $id;
            $transaksi = Transaksi::with([
                    'detail.menu',
                    'meja'
                ])
                ->where('meja_id', $id)
                ->whereIn('status', ['pending', 'selesai'])
                ->latest()
                ->first();
        }
    }

    return view('transaction.index', compact(
        'menu',
        'transaksi',
        'mejaId'
    ));
}
    public function simpan(Request $request)
    {
        $total = 0;
        foreach ($request->menu_id as $key => $menuId) {
            $total += $request->harga[$key] * $request->qty[$key];
        }

        if ($request->transaksi_id) {
            $transaksi = Transaksi::findOrFail( $request->transaksi_id );
            $transaksi->update([
                'meja_id' => $request->meja_id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'total_harga'    => $total,
                'bayar'          => $request->status === 'paid'
                    ? $request->bayar
                    : 0,
                'kembalian'      => $request->status === 'paid'
                    ? ($request->bayar - $total)
                    : 0,
                'status'         => $request->status,
                'waktu_bayar'    => $request->status === 'paid'
                    ? ($transaksi->waktu_bayar ?? now())
                    : null,
            ]);

            DetailTransaksi::where( 'transaksi_id', $transaksi->id )->delete();

        } else {

            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX' . time(),
                'meja_id' => $request->meja_id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'total_harga'    => $total,
                'bayar'          => $request->status === 'paid'
                    ? $request->bayar
                    : 0,
                'kembalian'      => $request->status === 'paid'
                    ? ($request->bayar - $total)
                    : 0,
                'status'         => $request->status,
                'waktu_bayar'    => $request->status === 'paid'
                    ? now()
                    : null,
            ]);
        }

        foreach ($request->menu_id as $key => $menuId) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'menu_id'      => $menuId,
                'harga'        => $request->harga[$key],
                'qty'          => $request->qty[$key],
                'subtotal'     => $request->harga[$key]
                                * $request->qty[$key],
            ]);
        }

        if ($request->status === 'paid') {
            Jurnal::where( 'transaksi_id', $transaksi->id )->delete();
            Jurnal::create([
                'transaksi_id' => $transaksi->id,
                'tanggal'      => now(),
                'keterangan'   => 'Penjualan ' . $transaksi->kode_transaksi,
                'akun'         => 'Kas',
                'debit'        => $total,
                'kredit'       => 0,
            ]);
            Jurnal::create([
                'transaksi_id' => $transaksi->id,
                'tanggal'      => now(),
                'keterangan'   => 'Penjualan ' . $transaksi->kode_transaksi,
                'akun'         => 'Penjualan',
                'debit'        => 0,
                'kredit'       => $total,
            ]);
        }

        return redirect()->route('transaction.index');
    }

    public function onhold()
    {
        $onhold = Transaksi::with('meja')
            ->whereIn('status', [
                'pending',
                'selesai'
            ])
            ->latest()
            ->paginate(7, ['*'], 'onhold_page');

        $riwayat = Transaksi::where('status', 'paid')
            ->latest()
            ->paginate(7, ['*'], 'history_page');

        return view('transaction.onhold', compact(
            'onhold',
            'riwayat'
        ));
    }

    public function destroyOnhold($id)
    {
        DetailTransaksi::where( 'transaksi_id', $id )->delete();
        Jurnal::where( 'transaksi_id', $id )->delete();
        Transaksi::find($id)?->delete();
        return back()->with(
            'success',
            'Transaksi berhasil dihapus.'
        );
    }
}