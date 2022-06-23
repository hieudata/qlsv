<?php
namespace App\Repositories\Student;

use App\Http\Requests\StudentRequest;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

interface StudentRepositoryInterface extends RepositoryInterface
{
    public function newStudent();
    public function search($request);
}