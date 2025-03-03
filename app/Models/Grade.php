<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cette classe représente une note.
 * Elle peut être associée à un élève et à un cours.
 * Elle permet de gérer les informations des notes.
 **/
class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'type',
        'score',
        'max_score',
        'comment',
        'grade_date',
        'semester'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
