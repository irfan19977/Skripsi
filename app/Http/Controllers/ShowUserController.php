<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ShowUserController extends Controller
{
    public function studentIndex()
    {
        $students = User::with('classRoom')->role('student')->orderBy('name', 'asc')->paginate(10);

        return view('show.indexst', compact('students'));
    }
}
