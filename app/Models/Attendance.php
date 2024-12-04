<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan migration Anda
    protected $table = 'attendances';

    // Field yang bisa di-mass assignment
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'date',
        'time',
        'status',
        'notes'
    ];

    // Relasi dengan User (Student)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi dengan Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Relasi dengan User (Teacher)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Scope untuk filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeDate($query, $date)
    {
        return $query->where('date', $date);
    }

    // Accessor untuk mendapatkan status dalam format yang lebih readable
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'hadir':
                return '<span class="badge badge-success">Hadir</span>';
            case 'izin':
                return '<span class="badge badge-warning">Izin</span>';
            case 'sakit':
                return '<span class="badge badge-info">Sakit</span>';
            case 'alpha':
                return '<span class="badge badge-danger">Alpha</span>';
            default:
                return '<span class="badge badge-secondary">Tidak Diketahui</span>';
        }
    }

    // Method untuk mengecek apakah siswa hadir
    public function isPresent()
    {
        return $this->status === 'hadir';
    }

    // Method untuk mendapatkan rekap kehadiran siswa per mata pelajaran
    public static function getAttendanceSummary($studentId, $subjectId)
    {
        return self::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->selectRaw('
                COUNT(*) as total_attendance,
                SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as present,
                SUM(CASE WHEN status = "izin" THEN 1 ELSE 0 END) as permission,
                SUM(CASE WHEN status = "sakit" THEN 1 ELSE 0 END) as sick,
                SUM(CASE WHEN status = "alpha" THEN 1 ELSE 0 END) as absent
            ')
            ->first();
    }
}
