<?php
namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Repositories\BaseRepository;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{
    public function getModel()
    {
        return Subject::class;
    }
    public function newSubject()
    {
        return new $this->model;
    }
}
