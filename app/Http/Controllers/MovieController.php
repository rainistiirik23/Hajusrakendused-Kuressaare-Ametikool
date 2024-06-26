<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $moviesCache = Cache::get('movies');
        $foreignMovieCache = Cache::get('foreignMovies');
        $foreignApiUrl = $request->query('foreignApiUrl');
        if ($foreignApiUrl) {
            if (!$foreignMovieCache) {
                $foreignMovieCache = Cache::put('foreignMovies', json_decode(file_get_contents($foreignApiUrl)), now()->addMinutes(30));
            }
        }
        if (!$moviesCache) {
            $movies = Movie::get();
            Cache::put('movies', $movies, now()->addMinutes(5));
            return Inertia::render('Movie/Movies', ['movies' => Cache::get('movies')]);
        }

        return Inertia::render('Movie/Movies', ['movies' => $moviesCache, 'foreignMovies' => $foreignMovieCache]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Movie::create($request->validate([
            'title' => ['required'],
            'image' => ['required'],
            'description' => ['required'],
            'director' => ['required'],
            'languages' => ['required'],
            'film_length' => ['required'],
        ]));
        return response('Movie has been added', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $limit = $request->query('limit');
        $foreignApiData = json_decode(file_get_contents($request->query('foreignApiUrl')));
        return response()->json(['data' => Movie::get()->take($limit), 'foreignApiData' => $foreignApiData], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
