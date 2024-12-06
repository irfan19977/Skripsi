<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ShowUserController extends Controller
{
    // Student
    public function studentIndex(Request $request)
    {
        $students = User::with('classRoom')
            ->role('student')
            ->orderBy('name', 'asc');

        if ($request->has('q')) {
            $students->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('nisn', 'like', '%' . $request->q . '%');
            });
        }

        $students = $students->paginate(10);

        return view('show.indexst', compact('students'));
    }

    public function printCards(Request $request)
    {
        $selectedStudentIds = $request->input('selected_students', []);
        
        // Fetch selected students
        $students = User::whereIn('id', $selectedStudentIds)->get();
        
        // Render a view for printing cards
        return view('show.print-cards-st', compact('students'));
    }

    // Teacher
    public function teacherIndex(Request $request)
    {
        $teachers = User::with('classRoom')
            ->role('teacher')
            ->orderBy('name', 'asc');

        if ($request->has('q')) {
            $teachers->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('nisn', 'like', '%' . $request->q . '%');
            });
        }

        $teachers = $teachers->paginate(10);

        return view('show.indextc', compact('teachers'));
    }

    public function printCardsTc(Request $request)
    {
        $selectedTeacherIds = $request->input('selected_teachers', []);
        
        // Fetch selected students
        $teachers = User::whereIn('id', $selectedTeacherIds)->get();
        
        // Render a view for printing cards
        return view('show.print-cards-tc', compact('teachers'));
    }
}
