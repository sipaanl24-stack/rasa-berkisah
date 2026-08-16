<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use App\Models\MenuBahan;
use App\Models\MenuMakanan;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menu = MenuMakanan::with('bahan.barang')->get();
        $barang = Inventory::all();

        foreach ($menu as $m) {
            if (in_array(strtolower($m->kategori), ['makanan ringan', 'makanan berat'])) {
                $m->kategori = 'Makanan';
            }
        }

        return view('menu.index', compact('menu', 'barang'));
    }
    public function store(Request $request)
    {
        $gambar = $this->uploadGambar($request);

        $menu = MenuMakanan::create([
            'nama_makanan' => $request->nama_makanan,
            'kategori'     => $request->kategori,
            'profit'       => $request->profit,
            'gambar'       => $gambar,
            'hpp'          => 0,
            'harga'        => 0
        ]);

        $hpp = $this->simpanBahan(
            $menu->menu_id,
            $request->barang_id,
            $request->jumlah_bahan
        );

        $harga = $hpp + ($hpp * $request->profit / 100);

        $menu->update([
            'hpp'   => $hpp,
            'harga' => $harga
        ]);

        return redirect('/menu');
    }

    public function update(Request $request, $id)
    {
        $menu = MenuMakanan::findOrFail($id);

        $gambar = $this->uploadGambar($request, $menu->gambar);

        MenuBahan::where('menu_id', $id)->delete();

        $hpp = $this->simpanBahan(
            $id,
            $request->barang_id,
            $request->jumlah_bahan
        );

        $harga = $hpp + ($hpp * $request->profit / 100);

        $menu->update([
            'nama_makanan' => $request->nama_makanan,
            'kategori'     => $request->kategori,
            'profit'       => $request->profit,
            'gambar'       => $gambar,
            'hpp'          => $hpp,
            'harga'        => $harga
        ]);

        return redirect('/menu');
    }

    public function delete($id)
    {
        $menu = MenuMakanan::findOrFail($id);

        MenuBahan::where('menu_id', $id)->delete();

        if ($menu->gambar) {
            $path = public_path('gambar/' . $menu->gambar);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $menu->delete();

        return redirect('/menu');
    }

    private function uploadGambar(Request $request, $gambarLama = null)
    {
        if (!$request->hasFile('gambar')) {
            return $gambarLama;
        }

        $file = $request->file('gambar');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(
            public_path('gambar'),
            $namaFile
        );

        return $namaFile;
    }

    private function simpanBahan($menuId, $barangId, $jumlahBahan)
    {
        $hpp = 0;
        if (!$barangId) {
            return $hpp;
        }

        foreach ($barangId as $key => $idBarang) {
            $barang = Inventory::find($idBarang);
            if (!$barang) {
                continue;
            }
            
            $jumlah = $jumlahBahan[$key];
            MenuBahan::create([
                'menu_id'       => $menuId,
                'barang_id'     => $idBarang,
                'jumlah_bahan'  => $jumlah
            ]);

            if ($barang->stock > 0) {
                $hpp +=
                    ($barang->harga / $barang->stock)
                    * $jumlah;
            }
        }
        return $hpp;
    }
}