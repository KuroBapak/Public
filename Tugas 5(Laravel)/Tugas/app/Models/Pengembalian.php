<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pengembalian';
    //protected $fillable = ['nama','nik'];
    protected $guarded = ['id_pengembalian'];
}