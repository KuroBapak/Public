<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Kritik;
use App\Models\User;
use App\Models\Peran;
use Illuminate\Http\Request;

class KritikController extends Controller
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
    public function create(User $user, Film $film, $id)
    {
        //
        $users      =   $user->all();
        $datafilm   =   $film->where('id', $id)->get();
        return view("kritik.create", compact('users', 'datafilm'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Peran $peran, $id)
    {
        //
        $request->validate([
            'content'   => 'required',
            'point'     => 'required',
        ]);

        Kritik::create([
            'user_id'   => $request['user_id'],
            'film_id'   => $request['film_id'],
            'content'   => $request['content'],
            'point'     => $request['point']
        ]);

        return redirect()->route('film.show', $id);  
    }

    /**
     * Display the specified resource.
     */
    public function show(Kritik $kritik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kritik $kritik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kritik $kritik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kritik $kritik)
    {
        //
    }
}