<?php

use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonScheduleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
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
    
    // Attendances
    Route::resource('/attendances', AttendancesController::class);
    Route::get('/students/find-by-nisn/{nisn}', [AttendancesController::class, 'findByNisn']);
    Route::post('/attendances/qr-scan', [AttendancesController::class, 'processScan'])
    ->name('attendances.qr-scan');


    //  Permission
    Route::resource('/permissions', PermissionController::class);

    // Roles
    Route::resource('/roles', RoleController::class);

    // User
    Route::resource('/users', UserController::class);
    Route::post('/rfid-detect', [UserController::class, 'handleRFIDDetection'])->name('rfid.detect');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
