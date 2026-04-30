<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieService
{
    protected $movieRepo;

    public function __construct(MovieRepositoryInterface $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    // =======================
    // GET ALL (HOMEPAGE)
    // =======================
    public function getAllMovies($request)
    {
        $movies = $this->movieRepo->getAll();

        // filter search (opsional)
        if ($request->search) {
            $movies = $movies->filter(function ($movie) use ($request) {
                return str_contains(strtolower($movie->judul), strtolower($request->search)) ||
                       str_contains(strtolower($movie->sinopsis), strtolower($request->search));
            });
        }

        return $movies;
    }

    // =======================
    // GET BY ID
    // =======================
    public function getMovieById($id)
    {
        return $this->movieRepo->findById($id);
    }

    // =======================
    // GET CATEGORY
    // =======================
    public function getAllCategories()
    {
        return Category::all();
    }

    // =======================
    // STORE
    // =======================
    public function storeMovie($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:movies,id',
            'judul' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'sinopsis' => 'required|string',
            'tahun' => 'required|integer',
            'pemain' => 'required|string',
            'foto_sampul' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect('movies/create')
                ->withErrors($validator)
                ->withInput();
        }

        $fileName = $this->uploadImage($request);

        $data = [
            'id' => $request->id,
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'sinopsis' => $request->sinopsis,
            'tahun' => $request->tahun,
            'pemain' => $request->pemain,
            'foto_sampul' => $fileName,
        ];

        return $this->movieRepo->store($data);
    }

    // =======================
    // UPDATE
    // =======================
    public function updateMovie($request, $id)
    {
        $movie = $this->movieRepo->findById($id);

        if ($request->hasFile('foto_sampul')) {
            $this->deleteImage($movie->foto_sampul);
            $fileName = $this->uploadImage($request);
        } else {
            $fileName = $movie->foto_sampul;
        }

        $data = [
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'sinopsis' => $request->sinopsis,
            'tahun' => $request->tahun,
            'pemain' => $request->pemain,
            'foto_sampul' => $fileName,
        ];

        return $this->movieRepo->update($id, $data);
    }

    // =======================
    // DELETE
    // =======================
    public function deleteMovie($id)
    {
        $movie = $this->movieRepo->findById($id);

        $this->deleteImage($movie->foto_sampul);

        return $this->movieRepo->delete($id);
    }

    // =======================
    // ADMIN DATA
    // =======================
    public function getAllMoviesAdmin()
    {
        return $this->movieRepo->getAll();
    }

    // =======================
    // EDIT DATA
    // =======================
    public function getEditData($id)
    {
        return [
            'movie' => $this->movieRepo->findById($id),
            'categories' => Category::all()
        ];
    }

    // =======================
    // HELPER: UPLOAD IMAGE
    // =======================
    private function uploadImage($request)
    {
        $fileName = Str::uuid() . '.' . $request->file('foto_sampul')->getClientOriginalExtension();
        $request->file('foto_sampul')->move(public_path('images'), $fileName);
        return $fileName;
    }

    // =======================
    // HELPER: DELETE IMAGE
    // =======================
    private function deleteImage($file)
    {
        if (File::exists(public_path('images/' . $file))) {
            File::delete(public_path('images/' . $file));
        }
    }
}
