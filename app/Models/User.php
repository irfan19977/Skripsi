<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_kartu',
        'name',
        'nisn',
        'email',
        'password',
        'qr_code',
        'no_wa',
        'province',
        'city',
        'district',
        'village',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class, 'student_id');
    }

    // Hapus method classRoom atau sesuaikan
    public function classRoom()
    {
        return $this->belongsToMany(ClassRoom::class, 'student_classes', 'student_id', 'class_room_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendances::class, 'student_id');
    }
}
