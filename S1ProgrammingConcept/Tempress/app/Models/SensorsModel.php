<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorsModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'sensors_tb';
    protected $primarykey = 'id';
    protected $fillable = ['temp','press','light','avgtemp','avgpress'];
}
