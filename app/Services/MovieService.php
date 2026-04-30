<?php

namespace App\Services;

use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieService
{
    protected $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getAllMovies()
    {
        return $this->movieRepository->getAll();
    }

    public function storeMovie($data)
    {
        return $this->movieRepository->store($data);
    }
}
