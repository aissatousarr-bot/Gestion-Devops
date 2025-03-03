<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query()
            ->withCount('courses')
            ->with('teachers');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%");
        }

        $subjects = $query->latest()->paginate(10);

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')
            ->whereHas('user', function($query) {
                $query->where('status', 'active');
            })
            ->get();
        return view('admin.subjects.form', compact('teachers'));
    }

    public function store(SubjectRequest $request)
    {
        $subject = Subject::create($request->validated());

        if ($request->has('teacher_ids')) {
            $subject->teachers()->attach($request->teacher_ids);
        }

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Matière créée avec succès');
    }

    public function edit(Subject $subject)
    {
        $teachers = Teacher::all();
        return view('admin.subjects.form', compact('subject', 'teachers'));
    }

    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        if ($request->has('teacher_ids')) {
            $subject->teachers()->sync($request->teacher_ids);
        }

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Matière mise à jour avec succès');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->courses()->exists()) {
            return back()->with('error', 'Impossible de supprimer une matière ayant des cours associés');
        }

        $subject->delete();
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Matière supprimée avec succès');
    }

    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }
}
