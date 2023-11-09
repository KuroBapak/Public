<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;
use App\Models\Pengembalian;


class Petugas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'petugas';
    protected $fillable = [
        'id',
        'nama_petugas',
        'jabatan_petugas',
        'no_telp_petugas',
        'alamat_petugas',
    ];

    public function pinjam()
    {
        return $this->hasOne(App\Models\Peminjaman::class);
    }

    public function kembali()
    {
        return $this->hasOne(App\Models\Pengembalian::class);
    }
}