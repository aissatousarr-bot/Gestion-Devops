<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * Cette classe représente une salle.
 * Elle peut contenir plusieurs cours et plusieurs emplois du temps.
 * Elle permet de gérer les informations des salles.
 **/
class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Nom ou numéro de la salle
        'number',      // Numéro unique de la salle
        'type',        // classroom, lab, conference, etc.
        'capacity',    // Capacité maximale
        'description', // Description optionnelle
        'status',      // available, maintenance, occupied
        'floor',       // Étage
        'building'     // Bâtiment
    ];

    // Relations
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function isAvailable($day, $startTime, $endTime, $excludeScheduleId = null)
    {
        return !$this->schedules()
            ->where('day', $day)
            ->where('status', 'active')
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })
            ->when($excludeScheduleId, function($query) use ($excludeScheduleId) {
                $query->where('id', '!=', $excludeScheduleId);
            })
            ->exists();
    }
}
