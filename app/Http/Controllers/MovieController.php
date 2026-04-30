<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $movies = $this->movieService->getAllMovies(request());
        return view('homepage', compact('movies'));
    }

    public function detail($id)
    {
        $movie = $this->movieService->getMovieById($id);
        return view('detail', compact('movie'));
    }

    public function create()
    {
        $categories = $this->movieService->getAllCategories();
        return view('input', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->movieService->storeMovie($request);
        return redirect('/')->with('success', 'Data berhasil disimpan');
    }

    public function data()
    {
        $movies = $this->movieService->getAllMoviesAdmin();
        return view('data-movies', compact('movies'));
    }

    public function form_edit($id)
    {
        $data = $this->movieService->getEditData($id);
        return view('form-edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->movieService->updateMovie($request, $id);
        return redirect('/movies/data')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->movieService->deleteMovie($id);
        return redirect('/movies/data')->with('success', 'Data berhasil dihapus');
    }
}
