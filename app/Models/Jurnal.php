<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'jurnal';

    protected $fillable = [
        'transaksi_id',
        'tanggal',
        'keterangan',
        'akun',
        'debit',
        'kredit'
    ];
}