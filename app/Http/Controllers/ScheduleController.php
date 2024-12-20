<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use App\Models\ClassRoom;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('schedules.index');

        $user = auth()->user();
        $userRoles = $user->roles->pluck('name');

        if ($userRoles->contains('admin')) {
            // Jika pengguna adalah admin, ambil semua jadwal
            $schedules = Schedule::with(['subject', 'teacher', 'classRoom'])
                ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                ->orderBy('start_time')
                ->paginate(10);
        } elseif ($userRoles->contains('student')) {
            // Jika pengguna adalah siswa, ambil jadwal berdasarkan kelasnya
            $studentClasses = $user->studentClasses; // Ambil semua kelas siswa
            if ($studentClasses->isNotEmpty()) {
                $classRoomIds = $studentClasses->pluck('class_room_id'); // Ambil ID kelas
                $schedules = Schedule::with(['subject', 'teacher', 'classRoom'])
                    ->whereIn('class_room_id', $classRoomIds)
                    ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                    ->orderBy('start_time')
                    ->paginate(10);
            } else {
                // Jika tidak ada kelas, kembalikan koleksi kosong
                $schedules = collect();
            }
        } elseif ($userRoles->contains('teacher')) {
            // Jika pengguna adalah guru, ambil jadwal mengajar berdasarkan ID guru
            $schedules = Schedule::with(['subject', 'classRoom'])
                ->where('teacher_id', $user->id) // Ambil jadwal berdasarkan ID guru
                ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                ->orderBy('start_time')
                ->paginate(10);
        } else {
            // Jika bukan admin, siswa, atau guru, kembalikan koleksi kosong
            $schedules = collect();
        }

        return view('schedules.index', compact('schedules'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('schedules.create');
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
        $this->authorize('schedules.edit');
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

    public function generateAttendanceLink($scheduleId)
{
    // Membuat signed URL yang berlaku selama 24 jam
    $signedUrl = URL::signedRoute('schedules.attendance', [
        'schedule' => $scheduleId
    ], now()->addDay());

    return $signedUrl;
}

public function showAttendance(string $scheduleId) {
    $user = auth()->user();
    $userRoles = $user->roles->pluck('name');
    $schedule = Schedule::findOrFail($scheduleId);
    $today = now()->format('Y-m-d'); // Mendapatkan tanggal hari ini

    // Untuk role guru
    if ($userRoles->contains('teacher')) {
        // Pastikan hanya guru yang mengajar mata pelajaran ini yang bisa mengakses
        if ($schedule->teacher_id !== $user->id) {
            abort(404, 'Unauthorized access');
        }

        // Ambil semua siswa di kelas yang sama dengan jadwal
        $students = User::whereHas('studentClasses', function ($query) use ($schedule) {
            $query->where('class_room_id', $schedule->class_room_id);
        })
        ->orderBy('name', 'desc') // Urutkan berdasarkan nama
        ->get();

        return view('schedules.attendance', [
            'schedule' => $schedule, 
            'students' => $students
        ]);
    }

    // Logika untuk siswa
    if ($userRoles->contains('student')) {
        $studentClasses = $user->studentClasses->pluck('class_room_id');

        if (!$studentClasses->contains($schedule->class_room_id)) {
            abort(404, 'Unauthorized access');
        }

        // Ambil kehadiran siswa untuk hari ini
        $attendances = Attendances::where('student_id', $user->id)
            ->where('subject_id', $schedule->subject_id)
            ->where('teacher_id', $schedule->teacher_id)
            ->whereDate('date', now()->format('Y-m-d')) // Filter berdasarkan tanggal hari ini
            ->orderBy('date', 'desc')
            ->get();

        return view('schedules.attendance', compact('schedule', 'attendances'));
    }

    // Jika bukan guru atau siswa
    abort(403, 'Unauthorized');
}

}
