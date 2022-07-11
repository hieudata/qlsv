<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return Student::class;
    }

    public function newStudent()
    {
        return new $this->model;
    }

    public function search($request)
    {
        $student = $this->model->with('subjects', 'faculty');

        // Age
        if (!empty($request['age_from'])) {
            $student->where('birthday', '<=', Carbon::now()->subYears($request['age_from']));
        }

        if (!empty($request['age_to'])) {
            $student->where('birthday', '>=', Carbon::now()->subYears($request['age_to']));
        }

        $phones = [
            'viettel' => '^037|^038|^039|^036',
            'vina' => '^070|^079|^078|^077',
            'mobi' => '^081|^082|^083|^084',
        ];

        if (!empty($request['viettel']) || !empty($request['vina']) || !empty($request['mobi'])) {
            $student->where(function ($query) use ($request, $phones) {
                foreach ($phones as $field => $phone) {
                    if (!empty($request[$field])) {
                        $query->orWhere('phone', 'regexp', $phone);
                    }
                }
            });
        }

        if (!empty($request['category'])) {

            $operator = '>=';

            if ($request['category'] == "2") {
                $operator = '<';
            }

            $student->whereHas('subjects', function ($q) {
                $q->where('point', '>', 0);
            }, $operator);
        }

        if (!empty($request['point_from']) && !empty($request['point_to'])) {
            $start = $request['point_from'];
            $end = $request['point_to'];

            $student->whereHas('subjects', function ($q) use ($start, $end) {
                $q->whereBetween('point', [$start, $end]);
            });
        }

        $paginate = 5;
        if (isset($request['paginate'])) {
            switch ($request['paginate']) {
                case 1:
                    $paginate = 10;
                    break;
                case 2:
                    $paginate = 100;
                    break;
                case 3:
                    $paginate = 500;
                    break;
            }
        }

        return $student->paginate($paginate);
    }
}
