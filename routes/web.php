<?php

use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonScheduleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShowUserController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Show User
    Route::get('/student', [ShowUserController::class, 'studentIndex'])->name('student.indexst');
    Route::post('/student', [ShowUserController::class, 'printCards'])->name('student.print-cards');
    
    // Show Teacher
    Route::get('/teacher', [ShowUserController::class, 'teacherIndex'])->name('teacher.indextc');
    Route::post('/teacher', [ShowUserController::class, 'printCardsTc'])->name('teacher.print-cards-tc');

    // Subjects
    Route::resource('/subjects', SubjectController::class);

    // Class
    Route::resource('/class', ClassController::class);
    Route::get('/class/{slug}', [ClassController::class, 'show'])->name('class.show');
    Route::get('/class/{slug}/edit-assign', [ClassController::class, 'editAssign'])
    ->name('class.edit-assign');
    Route::put('/class/{slug}/update-assign', [ClassController::class, 'updateAssign'])
    ->name('class.update-assign');
    
    // Schedules
    Route::resource('/schedules', ScheduleController::class);
    Route::get('/schedules/{schedule}/attendance', [ScheduleController::class, 'showAttendance'])->name('schedules.attendance');
    
    // Attendances
    Route::resource('/attendances', AttendancesController::class);
    Route::get('/students/find-by-nisn/{nisn}', [AttendancesController::class, 'findByNisn']);
    Route::post('/attendances/scan-qr', [AttendancesController::class, 'scanQrAttendance'])
    ->name('attendances.scan-qr');
    Route::get('/attendances/trigger-alpha-otomatis', [AttendancesController::class, 'triggerAlpaOtomatis']);


    //  Permission
    Route::resource('/permissions', PermissionController::class);

    // Roles
    Route::resource('/roles', RoleController::class);

    // User
    Route::resource('/users', UserController::class);
    
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
});
Route::post('/rfid-detect', [RFIDController::class, 'detect'])->name('rfid.detect');
Route::get('/get-latest-rfid', [RFIDController::class, 'getLatestRFID'])->name('get.latest.rfid');
Route::post('/clear-rfid', [RFIDController::class, 'clearRFID'])->name('clear.rfid');


require __DIR__.'/auth.php';
