<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'subject_id',
        'teacher_id',
        'room_id',
        'day',
        'start_time',
        'end_time',
        'status',
        'semester',
        'academic_year',
        'notes'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Relations
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Accesseurs
    public function getDurationAttribute()
    {
        return now()->createFromTimeString($this->start_time)
                ->diffInMinutes(now()->createFromTimeString($this->end_time)) . ' minutes';
    }

    public function getDayNameAttribute()
    {
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi'
        ];
        return $days[$this->day];
    }

    // Scopes pour le filtrage
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCurrentSemester($query)
    {
        return $query->where('semester', 'S1');
    }

    public function scopeCurrentAcademicYear($query)
    {
        return $query->where('academic_year', '2024-2025');
    }
}
