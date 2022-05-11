<?php

namespace App\Repositories\Faculty;

use App\Repositories\BaseRepository;
use App\Models\Faculty;

class FacultyRepository extends BaseRepository implements FacultyRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Faculty::class;
    }

    public function newFaculty()
    {
        return new Faculty();
    }
    public function pluck()
    {
        return Faculty::pluck('name', 'id');
    }
}
