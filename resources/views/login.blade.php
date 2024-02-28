<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class UserController extends Controller
{
    // Metode untuk menampilkan halaman login
    public function login()
    {
        return view('login');
    }

    // Metode untuk menangani proses login
    public function authenticate(Request $request)
    {
        // Validasi input dari form login
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman login dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Autentikasi pengguna
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, redirect ke halaman dashboard atau ke halaman yang sesuai
            return redirect()->intended('/dashboard');
        } else {
            // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
            return redirect()->back()->with('error', 'Email atau password salah')->withInput();
        }
    }

    // Metode untuk menangani proses logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
