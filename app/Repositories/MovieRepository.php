<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAll()
    {
        return Movie::latest()->paginate(10);
    }

    public function findById($id)
    {
        return Movie::findOrFail($id);
    }

    public function store($data)
    {
        return Movie::create($data);
    }

    public function update($id, $data)
    {
        $movie = Movie::findOrFail($id);
        return $movie->update($data);
    }

    public function delete($id)
    {
        $movie = Movie::findOrFail($id);
        return $movie->delete();
    }
}
