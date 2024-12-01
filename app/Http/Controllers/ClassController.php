<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Classs;
use App\Models\Student_Classes;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('class.index');

        $classes = ClassRoom::latest()->when(request()->q, function($classes) {
            $classes = $classes->where('name', 'like', '%' . request()->q . '%' );
        })->paginate(10);

        return view('class.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('class.create');
        return view('class.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'grade' => 'required',
        ]);

        $classes = ClassRoom::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'grade' => $request->input('grade'),
        ]);

        if ($classes) {
            return redirect()->route('class.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        } else {
            return redirect()->route('class.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Ambil data kelas berdasarkan slug
        $class = ClassRoom::where('slug', $slug)->firstOrFail();

        // Ambil siswa yang terdaftar di kelas ini
        $students = StudentClass::where('class_room_id', $class->id)
            ->with('student')  // Pastikan relasi student sudah terdefinisi di model StudentClass
            ->get();

        // Tampilkan ke view 'class.show' dengan data kelas dan siswa
        return view('class.show', compact('class', 'students'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $this->authorize('class.edit');
        $classes = ClassRoom::where('Slug', $slug)->firstOrFail();

        return view('class.edit', compact('classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'name' => 'required',
            'grade' => 'required',
        ]);

        $classes = ClassRoom::where('slug', $slug)->firstOrFail();
        $classes->update([
            'name'  => $request->input('name'),
            'slug'  => Str::slug($request->input('name')),
            'grade'  => $request->input('grade'),
        ]);

        if ($classes) {
            return redirect()->route('class.index')->with(['success' => 'Data Berhasil Diperbarui']);
        } else {
            return redirect()->route('class.index')->with(['error' => 'Data Gagal Diperbarui']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classes = ClassRoom::findOrFail($id);
        $classes->delete();

        if ($classes) {
            return response()->json(['success' => true, 'message' => 'Data Berhadil Dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data Gagal Dihapus']);
        }
    }

    /**
 * Assign students to a class
 */

    public function editAssign($slug)
    {
        // Find the class
        $class = ClassRoom::where('slug', $slug)->firstOrFail();
    
        // Get students in this class
        $assignedStudents = StudentClass::where('class_room_id', $class->id)
            ->with('student')
            ->get();
    
        // Get students not assigned to any class
        $availableStudents = User::role('student')
            ->whereDoesntHave('studentClasses')  // Cek siswa belum masuk kelas manapun
            ->get();
    
        return view('class.edit-assign', compact('class', 'assignedStudents', 'availableStudents'));
    }
 

    public function updateAssign(Request $request, $slug)
    {
        $class = ClassRoom::where('slug', $slug)->firstOrFail();

        // Remove existing students if needed
        if ($request->has('remove_student_ids')) {
            StudentClass::where('class_room_id', $class->id)
                ->whereIn('student_id', $request->input('remove_student_ids'))
                ->delete();
        }

        // Add new students
        if ($request->has('student_ids')) {
            foreach ($request->input('student_ids') as $studentId) {
                StudentClass::create([
                    'class_room_id' => $class->id,
                    'student_id' => $studentId,
                    'academic_year' => $request->input('academic_year')
                ]);
            }
        }

        return redirect()->route('class.edit-assign', $class->slug)
            ->with('success', 'Daftar siswa kelas berhasil diperbarui');
    }
}
