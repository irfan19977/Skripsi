<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    
    public function edit()
    {
        $user = Auth::user();
        $provinces = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();

        // Ambil data kabupaten jika user sudah memiliki province
        $regencies = [];
        if ($user->province) {
            $regencies = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$user->province}.json")->json();
        }

        // Ambil data kecamatan jika user sudah memiliki regency
        $districts = [];
        if ($user->city) {
            $districts = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$user->city}.json")->json();
        }

        // Ambil data desa jika user sudah memiliki district
        $villages = [];
        if ($user->district) {
            $villages = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$user->district}.json")->json();
        } 

        return view('profile.index', compact('user', 'provinces', 'regencies', 'districts', 'villages'));
    }


    // Proses update profil
    public function update(Request $request, $id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id); 

        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'no_wa' => 'nullable|string|max:15',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
        ]);

        // Update data pengguna
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->no_wa = $request->input('no_wa');
        // $user->bio = $request->input('bio');
        $user->province = $request->input('province');
        $user->city = $request->input('city');
        $user->district = $request->input('district');
        $user->village = $request->input('village');
        $user->alamat = $request->input('alamat');

        // Simpan perubahan ke database
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
