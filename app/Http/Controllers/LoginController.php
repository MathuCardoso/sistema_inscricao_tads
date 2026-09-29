<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller {
    public function index() {
        return Inertia::render('Login');
    }

    public function login(Request $request) {
        $validated = $request->validate(
            [
                'user' => 'required',
                'password' => 'required'
            ]
        );

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return \redirect()->intended('/dashboard');
        }

        return \back()->withErrors([
            'login' => 'Credenciais Inválidas.'
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return \redirect('/login');
    }
}
