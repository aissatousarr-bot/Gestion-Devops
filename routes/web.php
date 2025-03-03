<?php

use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\{RoomController, UserController, ClassController, SubjectController, ScheduleController};
use App\Http\Controllers\Teacher\{
    CourseController as TeacherCourseController,
    GradeController as TeacherGradeController,
    AttendanceController as TeacherAttendanceController
};
use App\Http\Controllers\Student\{
    CourseController as StudentCourseController,
    GradeController as StudentGradeController,
    ScheduleController as StudentScheduleController
};
use App\Http\Controllers\Parent\{
    ChildrenController,
    GradeController as ParentGradeController,
    AttendanceController as ParentAttendanceController,
    ScheduleController as ParentScheduleController
};
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// Routes pour l'administrateur
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('rooms', RoomController::class);
    });
});

// Routes pour les enseignants
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherCourseController::class, 'index'])->name('teacher.dashboard');
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('courses', [TeacherCourseController::class, 'index'])->name('courses');
        Route::get('courses/{course}', [TeacherCourseController::class, 'show'])->name('courses.show');

        Route::resource('grades', TeacherGradeController::class);
        Route::post('grades/bulk', [TeacherGradeController::class, 'bulkStore'])->name('grades.bulk.store');

        Route::resource('attendance', TeacherAttendanceController::class);
        Route::post('attendance/bulk', [TeacherAttendanceController::class, 'bulkStore'])->name('attendance.bulk.store');
    });
});

// Routes pour les étudiants
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentCourseController::class, 'index'])->name('student.dashboard');
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('courses', [StudentCourseController::class, 'index'])->name('courses');
        Route::get('courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');

        Route::get('grades', [StudentGradeController::class, 'index'])->name('grades');
        Route::get('schedule', [StudentScheduleController::class, 'index'])->name('schedule');
    });
});

// Routes pour les parents
Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/dashboard', [ParentGradeController::class, 'index'])->name('parent.dashboard');
    Route::prefix('parent')->name('parent.')->group(function () {
        Route::get('children', [ChildrenController::class, 'index'])->name('children');
        Route::get('children/{child}', [ChildrenController::class, 'show'])->name('children.show');

        Route::get('grades', [ParentGradeController::class, 'index'])->name('grades');
        Route::get('grades/{child}', [ParentGradeController::class, 'show'])->name('grades.show');

        Route::get('attendance', [ParentAttendanceController::class, 'index'])->name('attendance');
        Route::get('attendance/{child}', [ParentAttendanceController::class, 'show'])->name('attendance.show');

        Route::get('schedule', [ParentScheduleController::class, 'index'])->name('schedule');
        Route::get('schedule/{child}', [ParentScheduleController::class, 'show'])->name('schedule.show');
    });
});

// Routes du profil (communes à tous les utilisateurs)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

