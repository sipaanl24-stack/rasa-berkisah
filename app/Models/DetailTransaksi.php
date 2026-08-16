<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'harga',
        'qty',
        'subtotal'
    ];

    public function menu()
    {
        return $this->belongsTo(
            MenuMakanan::class,
            'menu_id',
            'menu_id'
        );
    }

     public function transaksi()
    {
        return $this->belongsTo(
            Transaksi::class,
            'transaksi_id'
        );
    }
}