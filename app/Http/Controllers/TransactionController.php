<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Jurnal;
use App\Models\MenuMakanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
    // =========================================================
    // VALIDASI DASAR
    // =========================================================

    $request->validate([
        'status' => 'required|in:pending,paid',
        'nama_pelanggan' => 'nullable|string|max:255',
    ]);


    // =========================================================
    // VALIDASI PEMBAYARAN
    // =========================================================

    if ($request->status === 'paid') {

        $request->validate([
            'bayar' => 'required|numeric|min:1',
        ], [
            'bayar.required' => 'Nominal Harus Diisi',
        ]);
    }


    // =========================================================
    // CEK MENU
    // =========================================================

    if (!$request->has('menu_id') || empty($request->menu_id)) {

        return back()
            ->withInput()
            ->with('error', 'Belum ada menu yang dipilih.');
    }


    // =========================================================
    // HITUNG TOTAL TRANSAKSI
    // =========================================================

    $total = 0;

    foreach ($request->menu_id as $key => $menuId) {

        $harga = (float) $request->harga[$key];
        $qty = (int) $request->qty[$key];

        $total += $harga * $qty;
    }


    // =========================================================
    // CEK NOMINAL PEMBAYARAN
    // =========================================================

    if (
        $request->status === 'paid' &&
        (float) $request->bayar < $total
    ) {

        return back()
            ->withInput()
            ->withErrors([
                'bayar' => 'Nominal pembayaran kurang dari total transaksi.',
            ]);
    }


    // =========================================================
    // HITUNG BAYAR & KEMBALIAN
    // =========================================================

    $bayar = $request->status === 'paid'
        ? (float) $request->bayar
        : 0;

    $kembalian = $request->status === 'paid'
        ? $bayar - $total
        : 0;


    // =========================================================
    // UPDATE / BUAT TRANSAKSI
    // =========================================================

    if ($request->transaksi_id) {

        // -----------------------------------------------------
        // UPDATE TRANSAKSI LAMA
        // -----------------------------------------------------

        $transaksi = Transaksi::findOrFail(
            $request->transaksi_id
        );

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


        // Hapus detail transaksi lama
        DetailTransaksi::where(
            'transaksi_id',
            $transaksi->id
        )->delete();

    } else {

        // -----------------------------------------------------
        // BUAT TRANSAKSI BARU
        // -----------------------------------------------------

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


    // =========================================================
    // SIMPAN DETAIL TRANSAKSI
    // =========================================================

    foreach ($request->menu_id as $key => $menuId) {

        $harga = (float) $request->harga[$key];
        $qty = (int) $request->qty[$key];

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'menu_id' => $menuId,
            'harga' => $harga,
            'qty' => $qty,
            'subtotal' => $harga * $qty,
        ]);
    }


    // =========================================================
    // BUAT JURNAL JIKA SUDAH DIBAYAR
    // =========================================================

    if ($request->status === 'paid') {

        // Hapus jurnal lama jika transaksi sebelumnya pernah dibuat
        Jurnal::where(
            'transaksi_id',
            $transaksi->id
        )->delete();


        // -----------------------------------------------------
        // DEBIT KAS
        // -----------------------------------------------------

        Jurnal::create([
            'transaksi_id' => $transaksi->id,
            'tanggal' => now(),
            'keterangan' =>
                'Penjualan ' . $transaksi->kode_transaksi,
            'akun' => 'Kas',
            'debit' => $total,
            'kredit' => 0,
        ]);


        // -----------------------------------------------------
        // KREDIT PENJUALAN
        // -----------------------------------------------------

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


    // =========================================================
    // SELESAI - TRANSAKSI PAID
    // =========================================================

    if ($request->status === 'paid') {

        return redirect()
            ->route('transaction.index')
            ->with([
                'success' => 'Transaksi Berhasil',
                'print_id' => $transaksi->id,
            ]);
    }


    // =========================================================
    // SELESAI - TRANSAKSI PENDING
    // =========================================================

    return redirect()
        ->route('transaction.index')
        ->with(
            'success',
            'Pesanan berhasil disimpan.'
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

    public function print($id)
    {
        $transaksi = Transaksi::with([
            'detail.menu',
            'meja'
        ])->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'transaction.thermal',
            compact('transaksi')
        );

        $pdf->setPaper([0, 0, 226.77, 600]);

        return $pdf->stream(
            'struk-' . $transaksi->kode_transaksi . '.pdf'
        );
    }
}