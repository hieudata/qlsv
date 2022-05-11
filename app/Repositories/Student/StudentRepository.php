<?php
namespace App\Repositories\Student;

use App\Models\Student;
use App\Repositories\BaseRepository;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Student::class;
    }
    public function newStudent()
    {
        return new Student();
    }
}