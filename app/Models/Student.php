<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'avatar','phone', 'gender', 'email','birthday','faculty_id'];
    public function url()
    {
        return $this->id ? 'students.update' : 'students.store'; 
    }
    public function method()
    {
        return $this->id ? 'PUT' : 'POST'; 
    }

    public function faculty()
    {
        return $this->hasMany(Faculty::class);
    }
    /**
     * The subjects that belong to the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
    }
}
