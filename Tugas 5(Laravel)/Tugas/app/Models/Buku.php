<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Models\Rak;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class Buku extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'bukus';
    protected $fillable = [
        'id',
        'kode_buku',
        'judul_buku',
        'penulis_buku',
        'penerbit_buku',
        'tahun_penerbit',
        'stok',
    ];

    public function rak()
    {
        return $this->hasMany(App\Models\Rak::class);
    }

    public function pinjam()
    {
        return $this->hasMany(App\Models\Peminjaman::class);
    }

    public function kembali()
    {
        return $this->hasMany(App\Models\Pengembalian::class);
    }
}