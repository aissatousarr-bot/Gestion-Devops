<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'birth_date',
        'gender',
        'classroom_id',
        'user_id'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
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
