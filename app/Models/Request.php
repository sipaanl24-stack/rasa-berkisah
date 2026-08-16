<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'kode_request',
        'nama_bahan',
        'kategori',
        'sisa_stock',
        'satuan',
        'keterangan',
        'tanggal_kirim',
        'status',
        'keterangan_penolakan'
    ];
}