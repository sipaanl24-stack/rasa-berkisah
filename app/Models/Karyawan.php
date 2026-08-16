<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = [
        'kode_karyawan',
        'nama_karyawan',
        'email',
        'password',
        'role',
        'status',
        'kontak'
    ];

    public function shift()
    {
        return $this->hasMany(ShiftKaryawan::class);
    }
}