<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $meja = Meja::where('is_active', 1)
            ->with([
                'transaksi' => function ($query) {
                    $query->whereIn('status', ['pending', 'selesai'])
                        ->with('detail.menu')
                        ->latest();
                }
            ])
            ->orderBy('area')
            ->orderBy('nama_meja')
            ->get();

        return view('pos.index', compact('meja'));
    }

    public function manage()
    {
        $meja = Meja::orderBy('area')
            ->orderBy('nama_meja')
            ->get();

        return view('pos.meja', compact('meja'));
    }

   public function store(Request $request)
   {
        $request->validate([ 'area' => 'required|in:Indoor,Outdoor',  ]);
        $jumlah = Meja::where('area', $request->area)
            ->where('is_active', 1)
            ->count() + 1;
        $prefix = strtoupper(substr($request->area, 0, 1));

        Meja::create([
            'kode_meja' => $prefix . str_pad($jumlah, 2, '0', STR_PAD_LEFT),
            'nama_meja' => 'Meja ' . $jumlah,
            'kapasitas' => 4,
            'area' => $request->area,
            'bentuk' => 'bulat',
            'posisi_x' => 50,
            'posisi_y' => 50,
            'status' => 'kosong',
            'is_active' => 1,
        ]);
        return back()->with('success', 'Meja berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);

        $request->validate([
            'nama_meja' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'area'      => 'required|in:Indoor,Outdoor,VIP',
            'bentuk' => 'required|in:bulat,kotak,persegi,vip',
        ]);

        $meja->update([
            'nama_meja' => $request->nama_meja,
            'kapasitas' => $request->kapasitas,
            'area'      => $request->area,
            'bentuk'    => $request->bentuk,
        ]);

        return redirect()->route('pos.index')
            ->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meja = Meja::findOrFail($id);

        // Soft delete
        $meja->update([
            'is_active' => 0
        ]);

        return back()->with('success', 'Meja berhasil dihapus.');
    }

    public function layout()
    {
        $meja = Meja::where('is_active', 1)
            ->orderBy('area')
            ->orderBy('nama_meja')
            ->get();

        return view('pos.layout', compact('meja'));
    }

    public function saveLayout(Request $request)
    {
        foreach ($request->positions as $position) {

            Meja::where('id', $position['id'])->update([
                'posisi_x' => $position['x'],
                'posisi_y' => $position['y'],
            ]);

        }

        return response()->json([
            'success' => true
        ]);
    }

    public function updateLayout(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);

        $meja->update([
            'posisi_x' => $request->x,
            'posisi_y' => $request->y,
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}