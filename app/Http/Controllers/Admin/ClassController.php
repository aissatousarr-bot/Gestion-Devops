<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Http\Requests\ClassroomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::query()
            ->withCount(['students' => function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('status', 'active');
                });
            }])
            ->with(['teachers' => function($query) {
                $query->select('teachers.*')
                    ->join('users', 'teachers.user_id', '=', 'users.id')
                    ->where('users.status', 'active');
            }]);

        // Filtres
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $classrooms = $query->latest()->paginate(10);

        return view('admin.classes.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('admin.classes.form', compact('teachers'));
    }

    public function store(ClassroomRequest $request)
    {
        DB::beginTransaction();
        try {
            $classroom = Classroom::create($request->validated());

            if ($request->has('teacher_ids')) {
                $classroom->teachers()->attach($request->teacher_ids);
            }

            DB::commit();
            return redirect()->route('admin.classes.index')
                ->with('success', 'Classe créée avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création de la classe');
        }
    }

    public function edit(Classroom $class)
    {
        $teachers = Teacher::all();
        return view('admin.classes.form', compact('class', 'teachers'));
    }

    public function update(ClassroomRequest $request, Classroom $classroom)
    {
        DB::beginTransaction();
        try {
            $classroom->update($request->validated());

            if ($request->has('teacher_ids')) {
                $classroom->teachers()->sync($request->teacher_ids);
            }

            DB::commit();
            return redirect()->route('admin.classes.index')
                ->with('success', 'Classe mise à jour avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour de la classe');
        }
    }

    public function show(Classroom $class)
    {
        $class->load(['students', 'teachers', 'courses']);
        return view('admin.classes.show', compact('class'));
    }

    public function destroy(Classroom $classroom)
    {
        try {
            if ($classroom->students()->count() > 0) {
                return back()->with('error', 'Impossible de supprimer une classe contenant des étudiants');
            }

            $classroom->delete();
            return redirect()->route('admin.classes.index')
                ->with('success', 'Classe supprimée avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression de la classe');
        }
    }
}
