<?php

use App\Http\Controllers\RFIDAttendanceController;
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/rfid-detect', [RFIDController::class, 'detect'])->name('rfid.detect');

