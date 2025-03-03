<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Classroom;

class ClassroomPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Tous les utilisateurs peuvent voir la liste des classes
    }

    public function view(User $user, Classroom $classroom): bool
    {
        return true; // Tous les utilisateurs peuvent voir une classe spécifique
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Classroom $classroom): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Classroom $classroom): bool
    {
        return $user->role === 'admin';
    }

    public function manageStudents(User $user, Classroom $classroom): bool
    {
        return $user->role === 'admin';
    }

    public function assignTeacher(User $user, Classroom $classroom): bool
    {
        return $user->role === 'admin';
    }

    public function viewSchedule(User $user, Classroom $classroom): bool
    {
        return true; // Tous les utilisateurs peuvent voir l'emploi du temps
    }

    public function manageSchedule(User $user, Classroom $classroom): bool
    {
        return $user->role === 'admin';
    }

    public function viewGrades(User $user, Classroom $classroom): bool
    {
        if ($user->role === 'admin' || $user->role === 'teacher') {
            return true;
        }

        if ($user->role === 'student') {
            return $classroom->students->contains('user_id', $user->id);
        }

        return false;
    }

    public function viewAttendance(User $user, Classroom $classroom): bool
    {
        if ($user->role === 'admin' || $user->role === 'teacher') {
            return true;
        }

        if ($user->role === 'student') {
            return $classroom->students->contains('user_id', $user->id);
        }

        return false;
    }
}
