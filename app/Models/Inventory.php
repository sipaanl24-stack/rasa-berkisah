<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'data_barang';

    protected $primaryKey = 'barang_id';

    protected $fillable = [
        'kode',
        'nama_bahan',
        'kategori',
        'stock',
        'satuan',
        'harga',
        'masuk',
        'expired',
    ];
}