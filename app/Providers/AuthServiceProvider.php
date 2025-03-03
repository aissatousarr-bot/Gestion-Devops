<?php
namespace App\Providers;

use App\Models\{ Course, Grade, Attendance, Classroom, User};
use App\Policies\{
    CoursePolicy,
    GradePolicy,
    AttendancePolicy,
    ClassroomPolicy,
    UserPolicy};
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Course::class => CoursePolicy::class,
        Grade::class => GradePolicy::class,
        Attendance::class => AttendancePolicy::class,
        Classroom::class => ClassroomPolicy::class,
    ];
}
