<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'occupation',
        'relationship_type', // père, mère, tuteur
        'emergency_contact',
        'user_id'
    ];

    // Relations
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student');
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
