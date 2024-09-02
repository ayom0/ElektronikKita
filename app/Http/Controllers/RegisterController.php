<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create()
    {
        return view('auth.register'); // Pastikan view ini ada di resources/views/auth/register.blade.php
    }

    /**
     * Menangani request registrasi pengguna.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);
    
        // Membuat pengguna baru
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'registration_date' => now(),
        ]);
    
        // Memicu event registrasi
        event(new Registered($user));
    
        // Log in pengguna
        Auth::login($user);
    
        // Redirect ke halaman dashboard pengguna
        return redirect()->route('usermanagement.index');
    }
}
