<?php

namespace App\Repositories\Interfaces;

interface MovieRepositoryInterface
{
    public function getAll();
    public function store($data);
}
