<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('users.index');
        $users = User::latest()->when(request()->q, function($users) {
            $users = $users->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        if ($request->ajax()) {
            return response()->view('users.table', compact('users'));  // Partial view untuk tabel
        }
        
        return view('users.index', compact('users'));
    }

    public function show(User $user) {
        $roles = Role::latest()->get();
        return view('users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('users.create');
        $roles = Role::latest()->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'role'      => 'required',
        ]);

        $user = User::create([
            'no_kartu'      => $request->input('no_kartu'),
            'name'      => $request->input('name'),
            'nisn'      => $request->input('nisn'),
            'email'     => $request->input('email'),
            'password'  => bcrypt('12345'),
        ]);

        //assign role
        $user->assignRole($request->input('role'));
        // Generate QR Code
        $qrCodeContent = "NISN: {$user->nisn}, NAMA: {$user->name}, EMAIL: {$user->email}";
        $qrCodeImage = QrCode::size(80)
            ->generate($qrCodeContent);

        // Save QR Code as HTML string or consider saving as a file
        $user->qr_code = $qrCodeImage; 
        $user->save();


        if($user){
            //redirect dengan pesan sukses
            return redirect()->route('users.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('users.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('users.edit');
        $roles = Role::latest()->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $this->validate($request, [
            'no_kartu'  => 'required',
            'name'      => 'required',
            'nisn'      => 'required',
            'email'     => 'required|email|unique:users,email,' . $id, // Mengecualikan email user saat ini dari validasi unique
            'role'      => 'required' // Pastikan role dipilih
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Update data user
        $user->no_kartu = $request->input('no_kartu');
        $user->name = $request->input('name');
        $user->nisn = $request->input('nisn');
        $user->email = $request->input('email');
        $user->password =bcrypt('12345');

        // Simpan perubahan pada user
        $user->save();

        // Update role
        if ($request->has('role')) {
            // Hapus role sebelumnya
            $user->roles()->detach();
            // Assign role baru
            $user->assignRole($request->input('role'));
        }

        // Regenerasi QR Code jika data penting berubah
        $qrCodeContent = "NISN: {$user->nisn}, NAMA: {$user->name}, EMAIL: {$user->email}";
        $qrCodeImage = QrCode::size(80)->generate($qrCodeContent);

        // Update QR code pada user
        $user->qr_code = $qrCodeImage;
        $user->save();

        // Redirect dengan pesan sukses atau error
        if ($user) {
            return redirect()->route('users.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('users.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();


        if($user){
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Data gagal dihapus.']);
        }
    }

    public function registerRfid(Request $request)
{
    $rfidCard = $request->input('rfid_card');

    // Simpan kartu RFID ke database
    $user = User::where('no_kartu', $rfidCard)->first();
    if (!$user) {
        $user = User::create([
            'no_kartu' => $rfidCard,
        ]);
    }

    return response()->json(['message' => 'Kartu RFID berhasil disimpan']);
}

// app/Http/Controllers/UserController.php
public function updateNoKartu(Request $request)
{
    $rfidCard = $request->input('rfid_card');

    // Cari pengguna berdasarkan no_kartu
    $user = User::where('no_kartu', $rfidCard)->first();

    // Perbarui nilai input no_kartu di view
    return response()->json(['no_kartu' => $user->no_kartu]);
}


}
