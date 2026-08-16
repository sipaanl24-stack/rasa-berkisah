<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'nama_pelanggan',
        'meja_id',
        'total_harga',
        'bayar',
        'kembalian',
        'status',
        'waktu_bayar'
    ];

    public function detail()
    {
        return $this->hasMany(
            DetailTransaksi::class,
            'transaksi_id'
        );
    }
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class);
    }

    public function meja()
    {
        return $this->belongsTo(
            Meja::class,
            'meja_id'
        );
    }
}