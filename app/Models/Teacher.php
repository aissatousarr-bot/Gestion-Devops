<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialty',
        'hire_date',
        'user_id'
    ];

    protected $casts = [
        'hire_date' => 'date'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_teacher');
    }

    public function getFullNameAttribute()
    {
        return $this->user->full_name;
    }

    // Déléguer les attributs à l'utilisateur
    public function __get($key)
    {
        $value = parent::__get($key);

        if ($value === null && $this->user) {
            return $this->user->$key;
        }

        return $value;
    }
}
