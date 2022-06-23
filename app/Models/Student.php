<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Student extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable = ['name', 'slug', 'avatar','phone', 'gender', 'email' ,'birthday','faculty_id'];

    const DONE = 1;
    const LEARNING = 2;

    public function url()
    {
        return $this->id ? 'students.update' : 'students.store'; 
    }

    public function method()
    {
        return $this->id ? 'PUT' : 'POST'; 
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    public $timestamps = false;
    /**
     * The subjects that belong to the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')->withTimestamps()->withPivot('point');
    }

    public function studentSubject()
    {
        return $this->belongsTo(StudentSubject::class, 'id', 'student_id');
    }
}
