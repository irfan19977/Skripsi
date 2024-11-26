<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        // $this->authorize('permissions.index');
        $permissions = Permission::latest()->when(request()->q, function($permissions) {
            $permissions = $permissions->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissions.create');
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permissions = Permission::create([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name'),
        ]);

        if ($permissions) {
            return redirect()->route('permissions.index')->with('success', 'Permission berhasil ditambahkan!');
        }else{
            return redirect()->back()->with('error', 'Gagal menambahkan permission. Coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('permissions.edit');
        $permissions = Permission::findOrFail($id);
        return view('permission.edit', compact('permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permissions = Permission::findOrFail($id);
        $permissions->update([
            'name' => $request->input('name'),
            'guard_name' => 'web',
        ]);
        
        if ($permissions) {
            return redirect()->route('permissions.index')->with('success', 'Permission berhasil ditambahkan!');
        }else{
            return redirect()->back()->with('error', 'Gagal menambahkan permission. Coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permissions = Permission::findOrFail($id);
        $permissions->delete();


        if($permissions){
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal dihapus.']);
        }
    }
    
    // Controller Method

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Permission::whereIn('id', $ids)->delete();
        return response()->json(["success"=>"Berhasil"]);
    }

}
