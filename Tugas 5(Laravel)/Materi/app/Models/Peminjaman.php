<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'peminjaman';
    //protected $fillable = ['nama','nik'];
    protected $guarded = ['id_peminjaman'];
}