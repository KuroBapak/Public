<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = 'films';
    protected $fillable = [
        'judul',
        'ringkasan',
        'tahun',
        'poster',
        'genre_id',
    ];

    public function genre() 
    {
        return $this->hasMany('App\Models\Genre', 'id', 'genre_id');
    }

    public function cast()
    {
        return $this->belongsToMany(Cast::class,'perans');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'kritiks');
    }

    public function peran()
    {
        return $this->hasMany(Peran::class);
    }

    public function kritik()
    {
        return $this->hasMany(Kritik::class);
    }
}