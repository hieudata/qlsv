<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();

    public function query();

    public function paginate();

    public function find($id);

    public function create($attributes = []);

    public function update($id, $attributes = []);

    public function delete($id);
}