<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RFIDController extends Controller
{
    public function detect(Request $request)
    {
        $rfidCard = $request->input('rfid_card');
        
        // Check if card is already in use by another user
        $existingUser = User::where('no_kartu', $rfidCard)
            ->where('id', '!=', request()->route('user'))
            ->first();
        
        if ($existingUser) {
            Cache::put('last_rfid_error', [
                'rfid' => $rfidCard,
                'status' => 'error',
                'message' => 'Kartu RFID sudah digunakan oleh ' . $existingUser->name,
                'is_used' => true
            ], now()->addMinutes(1));
            
            return response()->json([
                'status' => 'error',
                'message' => 'Kartu RFID sudah digunakan oleh ' . $existingUser->name,
                'is_used' => true,
                'rfid' => $rfidCard
            ], 400);
        }
        
        // Store RFID in cache
        Cache::put('last_rfid', [
            'rfid' => $rfidCard,
            'status' => 'success',
            'message' => 'RFID recorded successfully',
            'is_used' => false
        ], now()->addMinutes(1));
        
        return response()->json([
            'status' => 'success',
            'message' => 'RFID recorded successfully',
            'is_used' => false,
            'rfid' => $rfidCard
        ]);
    }

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
        
        // Check if card is already in use
        if (isset($rfidData['rfid'])) {
            $existingUser = User::where('no_kartu', $rfidData['rfid'])
                ->where('id', '!=', request()->route('user'))
                ->first();
            
            if ($existingUser) {
                Cache::forget('last_rfid');
                return response()->json([
                    'rfid' => $rfidData['rfid'],
                    'status' => 'error',
                    'message' => 'Kartu RFID sudah digunakan oleh ' . $existingUser->name,
                    'is_used' => true
                ]);
            }
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
