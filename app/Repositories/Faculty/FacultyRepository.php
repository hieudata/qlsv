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
    public function getFaculty()
    {
        return Faculty::paginate(5);
    }
}
