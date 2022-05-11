<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function url()
    {
        return $this->id ? 'subjects.update' : 'subjects.store'; 
    }
    public function method()
    {
        return $this->id ? 'PUT' : 'POST'; 
    }
    /**
     * The roles that belong to the Subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject');
    }
}
