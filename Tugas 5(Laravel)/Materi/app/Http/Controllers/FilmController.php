<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\ClodinoryStroge;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $films = Film::all();
        return view('film.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Genre $genre)
    {
        //
        $genres = $genre->all();
        return view('film.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Film $film)
    {
        //
        $request->validate([
            'judul' => 'required',
            'genre' => 'required',
            'tahun' => 'required',
            'ringkasan' => 'required',
            'poster' => 'required',
        ]);

        $image = $request->file('poster');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());


        $film::create([
            'judul' => $request['judul'],
            'genre_id' => $request['genre'],
            'tahun' => $request['tahun'],
            'ringkasan' => $request['ringkasan'],
            'poster' => $result,
        ]);
        return redirect()->route('film.index')->withSuccess('Film ini telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $film = Film::findOrFail($id); // Menggantikan $id dengan nilai id yang benar
        $genre = Genre::find($film->genre_id); // Mengambil genre yang terkait dengan film
        return view('film.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }
}