<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index(Request $request)
{
    $sort = $request->get('sort', 'kode');
    $direction = $request->get('direction', 'asc');
    $search = $request->get('search');
    $filter = $request->get('filter', 'all');
    $dateRange = $request->get('date_range');

    $allowedSort = [
        'kode',
        'nama_bahan'
    ];

    if (!in_array($sort, $allowedSort)) {
        $sort = 'kode';
    }

    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'asc';
    }

    $query = Inventory::query();

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if ($search) {

        $query->where(function ($q) use ($search) {

            $q->where('kode', 'like', "%{$search}%")
              ->orWhere('nama_bahan', 'like', "%{$search}%");

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Filter Waktu
    |--------------------------------------------------------------------------
    | Prioritas:
    | 1. Jika kalender dipilih -> gunakan kalender
    | 2. Jika kalender kosong -> gunakan dropdown
    |--------------------------------------------------------------------------
    */

    if (!empty($dateRange)) {

        $dates = explode(" to ", $dateRange);

        if (count($dates) == 2) {

            $query->whereBetween('masuk', [
                trim($dates[0]),
                trim($dates[1])
            ]);

        } elseif (count($dates) == 1) {

            $query->whereDate('masuk', trim($dates[0]));

        }

    } else {

        switch ($filter) {

            case 'today':

                $query->whereDate('masuk', today());

                break;

            case 'week':

                $query->whereBetween('masuk', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);

                break;

            case 'month':

                $query->whereMonth('masuk', now()->month)
                      ->whereYear('masuk', now()->year);

                break;

            case 'year':

                $query->whereYear('masuk', now()->year);

                break;

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    $data = $query
        ->orderBy($sort, $direction)
        ->paginate(5)
        ->withQueryString();

    return view('inventory.index', compact(
        'data',
        'sort',
        'direction',
        'search',
        'filter',
        'dateRange'
    ));
}

    public function store(Request $request)
    {
        $barangTerakhir = Inventory::latest()->first();

        if ($barangTerakhir) {

            $angka = substr($barangTerakhir->kode, 3);

            $kodeBaru = 'BRG' . str_pad($angka + 1, 3, '0', STR_PAD_LEFT);

        } else {

            $kodeBaru = 'BRG001';

        }

        Inventory::create([
            'kode'        => $kodeBaru,
            'nama_bahan'  => $request->nama_bahan,
            'kategori'    => $request->kategori,
            'stock'       => $request->stock,
            'satuan'      => $request->satuan,
            'harga'       => $request->harga,
            'masuk'       => $request->masuk,
            'expired'     => $request->expired,
        ]);

        return redirect('/inventory');
    }

    public function edit($barang_id)
    {
        $data = Inventory::find($barang_id);

        return view('inventory.edit', compact('data'));
    }

    public function update(Request $request, $barang_id)
    {
        $data = Inventory::find($barang_id);

        $data->update([
            'nama_bahan' => $request->nama_bahan,
            'kategori'   => $request->kategori,
            'stock'      => $request->stock,
            'satuan'     => $request->satuan,
            'harga'      => $request->harga,
            'masuk'      => $request->masuk,
            'expired'    => $request->expired,
        ]);

        return redirect('/inventory');
    }

    public function destroy($barang_id)
    {
        Inventory::destroy($barang_id);

        return redirect('/inventory');
    }
}