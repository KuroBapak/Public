<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Petugas;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalians';
    protected $fillable = [
        'id',
        'tanggal_pengembalian',
        'denda',
        'id_buku',
        'id_anggota',
        'id_petugas',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }
}