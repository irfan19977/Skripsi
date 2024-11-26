<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => 'required',
            'no_wa' => 'required|string|max:20',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'village' => 'required',
            'agree' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'no_wa' => $request->no_wa,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'village' => $request->village,
        ]);

        $role = Role::where('name', 'parent')->first();
        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.index', absolute: false));

        // // Generate QR code
        // $qrCode = $this->generateQrCode($user);


        // // Auth::login($user);

        // // return redirect(RouteServiceProvider::HOME)->with('qrcode', $qrCode);
        // return redirect()->route('coba', $user)
        //     ->with('success', 'User created successfully')
        //     ->with('qrCode', $qrCode);
    }


    private function generateQrCode(User $user)
    {
        $qrCode = uniqid('USER-');
        $user->update(['qr_code' => $qrCode]);

        return QrCode::size(300)->generate($qrCode);
    }

    public function show(User $user)
    {
        return view('coba', compact('user'));
    }
}
