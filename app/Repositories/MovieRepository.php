<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAll()
    {
        return Movie::all();
    }

    public function store($data)
    {
        return Movie::create($data);
    }
}
