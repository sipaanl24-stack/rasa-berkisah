<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuBahan extends Model
{
    protected $table = 'menu_bahan';

    protected $fillable = [
        'menu_id',
        'barang_id',
        'jumlah_bahan'
    ];

    public function barang()
    {
        return $this->belongsTo(Inventory::class, 'barang_id', 'barang_id');
    }
}