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
    // ==========================================
    // DATA MENU
    // ==========================================
    $menu = MenuMakanan::all();

    $oldDetail = [];


    // ==========================================
    // DATA OLD DETAIL
    // ==========================================
    if ($request->old('menu_id')) {

        foreach ($request->old('menu_id') as $key => $menuId) {

            $menuItem = $menu->firstWhere(
                'menu_id',
                $menuId
            );

            if ($menuItem) {

                $oldDetail[] = [
                    'menu_id' => $menuId,
                    'harga'   => $request->old(
                        "harga.$key",
                        $menuItem->harga
                    ),
                    'qty'     => $request->old(
                        "qty.$key",
                        1
                    ),
                    'menu'    => $menuItem,
                ];
            }
        }
    }


    // ==========================================
    // JUMLAH TRANSAKSI DITANGGUHKAN
    // ==========================================
    $jumlahDitangguhkan = Transaksi::whereIn('status', [
        'pending',
        'selesai'
    ])->count();


    // ==========================================
    // DATA TRANSAKSI
    // ==========================================
    $transaksi = null;
    $mejaId = null;

    if ($id) {

        // --------------------------------------
        // CARI BERDASARKAN ID TRANSAKSI
        // --------------------------------------
        $transaksiById = Transaksi::with([
            'detail.menu',
            'meja'
        ])->find($id);


        if ($transaksiById) {

            $transaksi = $transaksiById;
            $mejaId = $transaksiById->meja_id;

        } else {

            // ----------------------------------
            // JIKA ID ADALAH ID MEJA
            // ----------------------------------
            $mejaId = $id;

            $transaksi = Transaksi::with([
                'detail.menu',
                'meja'
            ])
            ->where('meja_id', $id)
            ->whereIn('status', [
                'pending',
                'selesai'
            ])
            ->latest()
            ->first();
        }
    }


    // ==========================================
    // KIRIM DATA KE VIEW
    // ==========================================
    return view('transaction.index', compact(
        'menu',
        'transaksi',
        'mejaId',
        'oldDetail',
        'jumlahDitangguhkan'
    ));
}

public function simpan(Request $request)
{
    // Validasi dasar
    $request->validate([
        'status' => 'required|in:pending,paid',
        'nama_pelanggan' => 'nullable|string|max:255',
    ]);

    // Jika status PAID, nominal bayar wajib diisi
    if ($request->status === 'paid') {

        $request->validate([
            'bayar' => 'required|numeric|min:1',
        ], [
            'bayar.required' => 'Nominal Harus Diisi',
        ]);
    }

    // Pastikan ada menu yang dipilih
    if (!$request->has('menu_id') || empty($request->menu_id)) {
        return back()->with('error', 'Belum ada menu yang dipilih.');
    }

    // Hitung total transaksi
    $total = 0;

    foreach ($request->menu_id as $key => $menuId) {
        $total += $request->harga[$key] * $request->qty[$key];
    }

    // Jika pembayaran kurang dari total
    if ($request->status === 'paid' && $request->bayar < $total) {
        return back()
            ->withInput()
            ->withErrors([
                'bayar' => 'Nominal pembayaran kurang dari total transaksi.',
            ]);
    }

    // Hitung kembalian
    $bayar = $request->status === 'paid'
        ? $request->bayar
        : 0;

    $kembalian = $request->status === 'paid'
        ? ($bayar - $total)
        : 0;

    // UPDATE TRANSAKSI YANG SUDAH ADA
    if ($request->transaksi_id) {

        $transaksi = Transaksi::findOrFail($request->transaksi_id);

        $transaksi->update([
            'meja_id' => $request->meja_id,
            'nama_pelanggan' => $request->nama_pelanggan,
            'total_harga' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'status' => $request->status,
            'waktu_bayar' => $request->status === 'paid'
                ? ($transaksi->waktu_bayar ?? now())
                : null,
        ]);

        DetailTransaksi::where(
            'transaksi_id',
            $transaksi->id
        )->delete();

    } else {

        // BUAT TRANSAKSI BARU
        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX' . time(),
            'meja_id' => $request->meja_id,
            'nama_pelanggan' => $request->nama_pelanggan,
            'total_harga' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'status' => $request->status,
            'waktu_bayar' => $request->status === 'paid'
                ? now()
                : null,
        ]);
    }

    // Simpan detail transaksi
    foreach ($request->menu_id as $key => $menuId) {

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'menu_id' => $menuId,
            'harga' => $request->harga[$key],
            'qty' => $request->qty[$key],
            'subtotal' =>
                $request->harga[$key] * $request->qty[$key],
        ]);
    }

    // Buat jurnal jika transaksi sudah dibayar
    if ($request->status === 'paid') {

        Jurnal::where(
            'transaksi_id',
            $transaksi->id
        )->delete();

        Jurnal::create([
            'transaksi_id' => $transaksi->id,
            'tanggal' => now(),
            'keterangan' =>
                'Penjualan ' . $transaksi->kode_transaksi,
            'akun' => 'Kas',
            'debit' => $total,
            'kredit' => 0,
        ]);

        Jurnal::create([
            'transaksi_id' => $transaksi->id,
            'tanggal' => now(),
            'keterangan' =>
                'Penjualan ' . $transaksi->kode_transaksi,
            'akun' => 'Penjualan',
            'debit' => 0,
            'kredit' => $total,
        ]);
    }

    return redirect()
        ->route('transaction.index')
        ->with(
            'success',
            $request->status === 'paid'
                ? 'Transaksi Berhasil'
                : 'Pesanan berhasil disimpan.'
        );
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

        $jumlahDitangguhkan = Transaksi::whereIn('status', [
            'pending',
            'selesai'
        ])->count();

        return view('transaction.onhold', compact(
            'onhold',
            'riwayat',
            'jumlahDitangguhkan'
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