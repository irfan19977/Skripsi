<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function Ramsey\Uuid\v1;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('subjects.index');
        $subjects = Subject::latest()->when(request()->q, function($subjects) {
            $subjects = $subjects->where('name', 'like', '%'. request()->q . '%')
            ->orWhere('code', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('subjects.create');
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $code = 'MP' . mt_rand(1000, 9999);

        $subjects = Subject::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'code' => $code,
        ]);

        if ($subjects) {
            return redirect()->route('subjects.index')->with(['success' => 'Data Berhasil Ditambahkan!!']);
        } else {
            return redirect()->route('subjects.index')->with(['Error' => 'Data Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $this->authorize('subjects.edit');
        $subjects = Subject::where('slug', $slug)->firstOrFail();

        return view('subjects.edit', compact('subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $subjects = Subject::where('slug', $slug)->firstOrFail();
        $subjects->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);

        if ($subjects) {
            return redirect()->route('subjects.index')->with(['success' => 'Data Berhasil Diperbarui']);
        } else {
            return redirect()->route('subjects.index')-> with(['error' => 'Data Gagal Diperbarui']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subjects = Subject::findOrFail($id);
        $subjects->delete();

        if ($subjects) {
            return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
        } else {
            return response()->json(['success' => false, 'massage' => 'Data Gagal Dihapus']);
        }
    }
}
