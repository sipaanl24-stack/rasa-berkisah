<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuMakanan extends Model
{
    protected $table = 'menu_makanan';

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'nama_makanan',
        'harga',
        'kategori',
        'hpp',
        'profit',
        'gambar'
    ];

    public function bahan()
    {
        return $this->hasMany(MenuBahan::class, 'menu_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'menu_id', 'menu_id');
    }
}