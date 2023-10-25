<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Peran;
use App\Models\Cast;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Cast $cast, Film $film, $id)
    {
        //
        $casts      =   $cast->all();
        $datafilm   =   $film->where('id', $id)->get();
        return view("peran.create", compact('casts', 'datafilm'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Peran $peran, $id)
    {
        //
        $request -> validate([
            'cast_id'   =>  'required',
            'peran' =>  'required'
        ]);

        $peran::create([
            'cast_id'   => $request ['cast_id'],
            'film_id'   => $request['film_id'],
            'nama'      => $request['peran'],
        ]);

        return redirect()->route('film.show', $id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Peran $peran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peran $peran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peran $peran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peran $peran)
    {
        //
    }
}