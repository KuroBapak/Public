<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Film;
use App\Models\User;

class Kritik extends Model
{
    use HasFactory;
    protected $table = "kritiks";
    protected $fillable = [
        'user_id',
        'film_id',
        'content',
        'point',
    ];

    public function film()
    {
        return $this->hasMany(Film::class, 'id', 'film_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }
}