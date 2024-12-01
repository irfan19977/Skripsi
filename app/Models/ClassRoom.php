<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'class_rooms';
    protected $guarded = [];

    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class, 'class_room_id');
    }
}
