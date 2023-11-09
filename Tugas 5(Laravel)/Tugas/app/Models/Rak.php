<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;

class Rak extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'rak';
    protected $fillable = [
        'id',
        'nama_rak',
        'lokasi_rak',
        'id_buku',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
    
}