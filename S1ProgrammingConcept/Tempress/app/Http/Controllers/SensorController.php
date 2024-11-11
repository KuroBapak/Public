<?php

namespace App\Http\Controllers;

use App\Models\SensorsModel;
use Illuminate\Http\Request;

class SensorController extends Controller
{

    public function flight()
    {
     $sensor = SensorsModel::select('*')->get();
     return view('Sensors.bacalight', ['nilaisensor' => $sensor]);
    }

    public function ftemp()
    {
     $sensor = SensorsModel::select('*')->get();
     return view('Sensors.bacatemp', ['nilaisensor' => $sensor]);
    }

    public function favgs()
    {
     $sensor = SensorsModel::select('*')->get();
     return view('Sensors.bacaavgs', ['nilaisensor' => $sensor]);
    }

    public function favgt()
    {
     $sensor = SensorsModel::select('*')->get();
     return view('Sensors.bacaavgt', ['nilaisensor' => $sensor]);
    }

    public function fpress()
    {
     $sensor = SensorsModel::select('*')->get();
     return view('Sensors.bacapress', ['nilaisensor' => $sensor]);
    }
    public function SimpanNilai()
    {
        SensorsModel::where('id', '1')->update(['temp' => request()->simpannilaitemp, 'press' => request()->simpannilaipress, 'light' => request()->simpannilailight]);
    }

    public function SimpanNilaiAvg()
    {
        SensorsModel::where('id', '1')->update(['avgtemp' => request()->simpannilaiavgt, 'avgpress' => request()->simpannilaiavgs]);
    }
}
