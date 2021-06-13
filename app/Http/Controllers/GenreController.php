<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    const styles = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark',
    ];

    public function __construct()
    {
        $this->middleware('is_libarian')->only(['create', 'store', 'edit', 'update', 'delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('genres.create', ['styles' => self::styles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|min:3|max:255',
                'style' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            ],
            [
                'name.required' => 'A nevet meg kell adni.',
                'name.min' => 'A név legalább :min karakter legyen.',
                'required' => 'A(z) :attribute mezőt meg kell adni.',
            ]
        );

        $genre = Genre::create($validated);

        $request->session()->flash('genre-created', $genre->name);
        return redirect()->route('genres.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        return view('genres.show', [
            'genre' => $genre,
            'books' => $genre->books
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        return view('genres.edit', ['styles' => self::styles, 'genre' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate(
            [
                'name' => 'required|min:3|max:255',
                'style' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            ],
            [
                'name.required' => 'A nevet meg kell adni.',
                'name.min' => 'A név legalább :min karakter legyen.',
                'required' => 'A(z) :attribute mezőt meg kell adni.',
            ]
        );

        $genre->update($validated);

        $request->session()->flash('genre-updated', $genre->name);
        return redirect()->route('genres.edit', $genre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        Genre::destroy($id);
        Session::flash('genre-deleted', $genre->name);
        return redirect()->route('books.index');
    }
}
