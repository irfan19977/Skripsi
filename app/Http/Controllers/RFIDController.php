<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RFIDController extends Controller
{
    protected $attendancesController;

    public function __construct(AttendancesController $attendancesController)
    {
        $this->attendancesController = $attendancesController;
    }

    public function detect(Request $request)
    {
        $rfidCard = $request->input('rfid_card');

        // Check if card is already in use by another user
        $existingUser = User::where('no_kartu', $rfidCard)
            ->where('id', '!=', request()->route('user'))
            ->first();

        if (!$existingUser) {
            Cache::put('last_rfid', [
                'rfid' => $rfidCard,
                'status' => 'error',
                'message' => 'Kartu RFID tidak terdaftar',
                'is_used' => false
            ], now()->addMinutes(1));

            return response()->json([
                'status' => 'error',
                'message' => 'Kartu RFID tidak terdaftar',
                'is_used' => false,
                'rfid' => $rfidCard
            ], 404);
        }

        try {
            // Get student's NISN
            $studentNisn = $existingUser->nisn;

            // Use the AttendancesController to handle attendance
            $attendanceResponse = $this->attendancesController->scanQRAttendance(new Request(['nisn' => $studentNisn]));
            $attendanceData = json_decode($attendanceResponse->getContent(), true);

            if ($attendanceResponse->getStatusCode() === 200 && ($attendanceData['success'] ?? false)) {
                Cache::put('last_rfid', [
                    'rfid' => $rfidCard,
                    'status' => 'success',
                    'message' => 'Absensi berhasil: ' . $attendanceData['student']['name'] . ' - ' . 
                                $attendanceData['student']['subject'] . ' - ' . 
                                $attendanceData['student']['class'],
                    'is_used' => true,
                    'attendance_data' => $attendanceData
                ], now()->addMinutes(1));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Absensi berhasil',
                    'is_used' => true,
                    'rfid' => $rfidCard,
                    'attendance_data' => $attendanceData
                ]);
            } else {
                $errorMessage = $attendanceData['message'] ?? 'Gagal melakukan absensi';
                Cache::put('last_rfid_error', [
                    'rfid' => $rfidCard,
                    'status' => 'error',
                    'message' => $errorMessage,
                    'is_used' => true
                ], now()->addMinutes(1));

                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage,
                    'is_used' => true,
                    'rfid' => $rfidCard
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('RFID Attendance Error: ' . $e->getMessage());
            Cache::put('last_rfid_error', [
                'rfid' => $rfidCard,
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'is_used' => true
            ], now()->addMinutes(1));

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem',
                'is_used' => true,
                'rfid' => $rfidCard
            ], 500);
        }
    }

    // Other existing methods remain the same...
    public function getLatestRFID()
    {
        // Check for error state first
        $errorState = Cache::get('last_rfid_error');
        if ($errorState) {
            Cache::forget('last_rfid_error');
            return response()->json($errorState);
        }

        $rfidData = Cache::get('last_rfid');
        if (!$rfidData) {
            return response()->json([
                'rfid' => null,
                'status' => 'success',
                'is_used' => false
            ]);
        }

        return response()->json($rfidData);
    }

    public function clearRFID()
    {
        Cache::forget('last_rfid');
        Cache::forget('last_rfid_error');

        return response()->json([
            'status' => 'success',
            'message' => 'RFID cache cleared'
        ]);
    }
}
