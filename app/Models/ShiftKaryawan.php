<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftKaryawan extends Model
{
    protected $table = 'shift_karyawan';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'shift'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}