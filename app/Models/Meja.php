<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'meja';
    protected $fillable = [
        'kode_meja',
        'nama_meja',
        'kapasitas',
        'area',
        'bentuk',
        'posisi_x',
        'posisi_y',
        'status',
        'is_active'
    ];

    public function transaksi()
    {
        return $this->hasMany(
            Transaksi::class,
            'meja_id'
        );
    }

    public function transaksiAktif()
{
    return $this->hasOne(
        Transaksi::class,
        'meja_id'
    )->whereIn('status', [
        'pending',
        'selesai'
    ])->latestOfMany();
}

}