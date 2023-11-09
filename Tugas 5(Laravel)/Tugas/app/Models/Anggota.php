<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class Anggota extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'anggotas';
    //protected $fillable = ['nama','nik'];
    protected $guarded = ['id_anggota'];

    public function pinjam()
    {
        return $this->hasOne(App\Models\Peminjaman::class);
    }

    public function kembali()
    {
        return $this->hasOne(App\Models\Pengembalian::class);
    }
}
