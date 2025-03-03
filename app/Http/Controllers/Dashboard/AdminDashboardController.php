<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Subject;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalStudents' => Student::count(),
            'totalTeachers' => Teacher::count(),
            'totalClassrooms' => Classroom::count(),
            'totalSubjects' => Subject::count(),
        ];

        return view('dashboard.admin.index', $data);
    }
}
