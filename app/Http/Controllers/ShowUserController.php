<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShowUserController extends Controller
{
    // Student
    public function studentIndex(Request $request)
    {
        $this->authorize('users.index');
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

        foreach ($students as $student) {
            // Ambil data kabupaten/kota
            if ($student->province && $student->city) {
                $regencies = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$student->province}.json")->json();
                $student->city_name = collect($regencies)->firstWhere('id', $student->city)['name'] ?? null;
            }

            // Ambil data kecamatan
            if ($student->city && $student->district) {
                $districts = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$student->city}.json")->json();
                $student->district_name = collect($districts)->firstWhere('id', $student->district)['name'] ?? null;
            }

            // Ambil data desa
            if ($student->district && $student->village) {
                $villages = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$student->district}.json")->json();
                $student->village_name = collect($villages)->firstWhere('id', $student->village)['name'] ?? null;
            }
        }

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
        $this->authorize('users.index');
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
