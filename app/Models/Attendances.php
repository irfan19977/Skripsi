<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $fillable = [
        'student_id', 
        'subject_id', 
        'teacher_id', 
        'date', 
        'time', 
        'status', 
        'notes'
    ];

    /**
     * Define relationship with Student (User)
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Define relationship with Teacher (User)
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Define relationship with Subject
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alfa'
        ];

        return $statusLabels[$this->status] ?? $this->status;
    }

    // Accessor for start time (optional, but can be useful)
    public function getStartTimeAttribute($value)
    {
        return Carbon::createFromTimeString($value);
    }

    // Accessor for end time (optional, but can be useful)
    public function getEndTimeAttribute($value)
    {
        return Carbon::createFromTimeString($value);
    }

    // Scope to find current schedule
    public function scopeCurrentSchedule($query, $classRoomId, $day, $currentTime)
    {
        return $query->where('class_room_id', $classRoomId)
            ->where('day', $day)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime);
    }

    // Method to check if this schedule is currently active
    public function isCurrentlyActive($currentTime = null)
    {
        $now = $currentTime ?? Carbon::now('Asia/Jakarta');
        $startTime = Carbon::createFromTimeString($this->start_time);
        $endTime = Carbon::createFromTimeString($this->end_time);

        return $now->between($startTime, $endTime);
    }
}
