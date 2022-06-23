<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class StudentSubject extends Pivot
{
    use HasFactory;
    protected $table = 'student_subject';
    // protected $fillable = ['student_id', 'subject_id', 'point'];

    // /**
    //  * The studentsubject that belong to the StudentSubject
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */
    // public function studentsubject()
    // {
    //     return $this->belongsToMany(StudentSubject::class, $this->table, 'student_id', 'subject_id');
    // }
}
