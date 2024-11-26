<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->when(request()->q, function($roles) {
            $roles = $roles->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::latest()->get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'array'
        ]);

        $role = Role::create([
            'name' => $request->input('name')
        ]);

            $role->syncPermissions($request->input('permissions'));

            if($role){
                //redirect dengan pesan sukses
                return redirect()->route('roles.index')->with(['success' => 'Data Berhasil Disimpan!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('roles.index')->with(['error' => 'Data Gagal Disimpan!']);
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
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    // Function to update the specified role in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'array'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    // Function to remove the specified role from storage
    public function destroy($id)
    {
        $roles = Role::findOrFail($id);
        $roles->delete();


        if($roles){
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal dihapus.']);
        }
    }
}
