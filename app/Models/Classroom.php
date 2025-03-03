<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cette classe représente une classe.
 * Elle peut contenir plusieurs élèves et plusieurs enseignants.
 * Elle permet de gérer les informations des classes.
 **/
class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Exemple: "Terminale S1"
        'section',     // Exemple: "Scientifique"
        'level',       // Exemple: 1, 2, 3 (année d'études)
        'capacity',    // Capacité maximale d'étudiants
        'academic_year', // Exemple: "2023-2024"
        'status'       // active, inactive
    ];

    // Relations
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'classroom_teacher');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Accesseurs
    public function getCurrentStudentsCountAttribute()
    {
        return $this->students()
            ->whereHas('user', function($query) {
                $query->where('status', 'active');
            })
            ->count();
    }

    public function getStudentsCountAttribute()
    {
        return $this->students()
            ->whereHas('user', function($query) {
                $query->where('status', 'active');
            })
            ->count();
    }

    public function getAvailableSeatsAttribute()
    {
        return $this->capacity - $this->current_students_count;
    }

    public static function active(){

        return self::where('status', 'active');

    }
}
