<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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

    Route::resource('/subjects', SubjectController::class);

    Route::resource('/class', ClassController::class);
    Route::get('/class/{slug}', [ClassController::class, 'show'])->name('class.show');
    
    Route::get('/class/{slug}/edit-assign', [ClassController::class, 'editAssign'])
    ->name('class.edit-assign');
    Route::put('/class/{slug}/update-assign', [ClassController::class, 'updateAssign'])
    ->name('class.update-assign');
    
    Route::resource('/permissions', PermissionController::class);

    Route::resource('/roles', RoleController::class);

    Route::resource('/users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
