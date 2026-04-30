<?php

namespace App\Repositories\Interfaces;

interface MovieRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function store($data);
    public function update($id, $data);
    public function delete($id);
}
