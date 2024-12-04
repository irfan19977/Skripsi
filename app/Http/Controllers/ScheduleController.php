<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua jadwal pelajaran dengan relasi subject, teacher, dan class room
        $schedules = Schedule::with(['subject', 'teacher', 'classRoom'])
        ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
        ->orderBy('start_time')
        ->paginate(10);


        return view('schedules.index', compact('schedules'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all(); // Mengambil semua mata pelajaran
        $teachers = User::role('teacher')->get(); // Mengambil semua guru
        $classRooms = ClassRoom::all(); // Mengambil semua kelas

        return view('schedules.create', compact('subjects', 'teachers', 'classRooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'class_room_id' => 'required|exists:class_rooms,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'academic_year' => 'required|string'
        ]);

        $schedules = Schedule::create([
            'subject_id'     => $request->input('subject_id'),
            'teacher_id'     => $request->input('teacher_id'),
            'class_room_id'  => $request->input('class_room_id'),
            'day'            => $request->input('day'),
            'start_time'     => $request->input('start_time'),
            'end_time'     => $request->input('end_time'),
            'academic_year'     => $request->input('academic_year'),
        ]);

        if ($schedules) {
            return redirect()->route('schedules.index')->with('success', 'Data Berhasil Disimpan');
        } else {
            return redirect()->route('schedules.index')->with('error', 'Data Gagal Disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $subjects = Subject::all();
        $teachers = User::role('teacher')->get();
        $classRooms = ClassRoom::all();

        return view('schedules.edit', compact('schedule', 'subjects', 'teachers', 'classRooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Add more precise validation
    $validated = $request->validate([
        'subject_id' => 'required|exists:subjects,id',
        'teacher_id' => 'required|exists:users,id',
        'class_room_id' => 'required|exists:class_rooms,id',
        'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'academic_year' => 'required|string'
    ]);

    
        $schedule = Schedule::findOrFail($id);

        $updated = $schedule->update($validated);

        if ($updated) {
            return redirect()->route('schedules.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->route('schedules.index')->with('error', 'Data Gagal Diupdate');
        }
    
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedules = Schedule::findOrFail($id);
        $schedules->delete();

        if ($schedules) {
            return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
        } else {
            return response()->json(['success' => false, 'massage' => 'Data Gagal Dihapus']);
        }
    }
}
