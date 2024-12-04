<?php

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

    // 
    Route::get('/student', [ShowUserController::class, 'studentIndex'])->name('student.indexst');

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
