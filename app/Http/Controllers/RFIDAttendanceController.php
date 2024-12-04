<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RFIDAttendanceController extends Controller
{
    public function processRFID(Request $request)
    {
        // Validasi input RFID
        $request->validate([
            'rfid_card' => 'required|string'
        ]);

        // Cari siswa berdasarkan nomor kartu RFID
        $student = User::where('no_kartu', $request->rfid_card)->first();

        if (!$student) {
            return response()->json([
                'success' => false, 
                'message' => 'Kartu RFID tidak terdaftar'
            ], 404);
        }

        // Dapatkan waktu saat ini
        $currentTime = Carbon::now();
        $currentDay = strtolower($currentTime->englishDayOfWeek);

        // Cari jadwal pelajaran saat ini
        $schedule = $this->getCurrentSchedule($currentTime, $currentDay, $student);

        if (!$schedule) {
            return response()->json([
                'success' => false, 
                'message' => 'Tidak ada mata pelajaran saat ini'
            ], 400);
        }

        // Cek apakah sudah absen
        $existingAttendance = Attendance::where('student_id', $student->id)
            ->where('subject_id', $schedule->subject_id)
            ->where('date', $currentTime->toDateString())
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false, 
                'message' => 'Anda sudah absen untuk mata pelajaran ini'
            ], 400);
        }

        // Buat record absensi
        $attendance = Attendance::create([
            'student_id' => $student->id,
            'subject_id' => $schedule->subject_id,
            'teacher_id' => $schedule->teacher_id,
            'date' => $currentTime->toDateString(),
            'time' => $currentTime->toTimeString(),
            'status' => 'hadir',
            'notes' => 'Absensi melalui RFID'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil',
            'student' => $student->name,
            'subject' => $schedule->subject->name
        ]);
    }

    protected function getCurrentSchedule($currentTime, $currentDay, $student)
    {
        // Ambil kelas siswa
        $studentClasses = $student->studentClasses->pluck('class_room_id');

        // Cari jadwal yang sesuai dengan:
        // 1. Hari saat ini
        // 2. Waktu saat ini berada di antara jam mulai dan selesai
        // 3. Kelas siswa
        return Schedule::where('day', $currentDay)
            ->where('start_time', '<=', $currentTime->toTimeString())
            ->where('end_time', '>=', $currentTime->toTimeString())
            ->whereIn('class_room_id', $studentClasses)
            ->first();
    }
}