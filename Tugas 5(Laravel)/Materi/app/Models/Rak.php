<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'rak';
    //protected $fillable = ['nama','nik'];
    protected $guarded = ['id_rak'];
}