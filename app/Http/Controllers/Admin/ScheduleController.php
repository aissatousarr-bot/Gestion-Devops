<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Http\Requests\ScheduleRequest;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Room;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['classroom', 'subject', 'teacher', 'room']);

        // Filtres
        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        // Récupérer les données pour les filtres
        $classrooms = Classroom::active()->get();
        $teachers = Teacher::whereHas('user', function($q) {
            $q->where('status', 'active');
        })->get();

        $schedules = $query->orderBy('day')
            ->orderBy('start_time')
            ->paginate(15);

        return view('admin.schedules.index', compact(
            'schedules',
            'classrooms',
            'teachers'
        ));
    }

    public function create()
    {
        $classrooms = Classroom::active()->get();
        $subjects = Subject::where('status', 'active')->get();
        $teachers = Teacher::whereHas('user', function($q) {
            $q->where('status', 'active');
        })->get();
        $rooms = Room::where('status', 'available')->get();

        return view('admin.schedules.form', compact(
            'classrooms',
            'subjects',
            'teachers',
            'rooms'
        ));
    }

    public function store(ScheduleRequest $request)
    {
        // Vérifier les conflits
        if ($this->hasConflict($request->validated())) {
            return back()->with('error', 'Conflit d\'horaire détecté !');
        }

        Schedule::create($request->validated());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Emploi du temps créé avec succès');
    }

    public function edit(Schedule $schedule)
    {
        $classrooms = Classroom::active()->get();
        $subjects = Subject::where('status', 'active')->get();
        $teachers = Teacher::whereHas('user', function($q) {
            $q->where('status', 'active');
        })->get();
        $rooms = Room::where('status', 'available')->get();

        return view('admin.schedules.form', compact(
            'schedule',
            'classrooms',
            'subjects',
            'teachers',
            'rooms'
        ));
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        // Vérifier les conflits (en excluant l'entrée actuelle)
        if ($this->hasConflict($request->validated(), $schedule->id)) {
            return back()->with('error', 'Conflit d\'horaire détecté !');
        }

        $schedule->update($request->validated());

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Emploi du temps mis à jour avec succès');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Emploi du temps supprimé avec succès');
    }

    private function hasConflict(array $data, $excludeId = null)
    {
        $query = Schedule::where('day', $data['day'])
            ->where(function($q) use ($data) {
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']]);
            })
            ->where(function($q) use ($data) {
                $q->where('room_id', $data['room_id'])
                    ->orWhere('teacher_id', $data['teacher_id']);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
