<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Attendance;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function view(User $user, Attendance $attendance): bool
    {
        return $user->role === 'admin' ||
            $user->role === 'teacher' ||
            $user->id === $attendance->student->user_id ||
            ($user->role === 'parent' && $user->student->contains($attendance->student_id));
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function update(User $user, Attendance $attendance): bool
    {
        return $user->role === 'admin' ||
            ($user->role === 'teacher' &&
                $user->id === $attendance->course->teacher->user_id);
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->role === 'admin';
    }

    public function markAttendance(User $user, Attendance $attendance): bool
    {
        return $user->role === 'admin' ||
            ($user->role === 'teacher' &&
                $user->id === $attendance->course->teacher->user_id);
    }

    public function viewReport(User $user): bool
    {
        return in_array($user->role, ['admin', 'teacher']);
    }
}

