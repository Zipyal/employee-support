<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    const VALIDATION_RULES_LOGIN = [
        'email' => 'required|email',
        'password' => 'required',
        'rememberMe' => 'nullable|boolean',
    ];

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('login');
        }

        $request->validate(self::VALIDATION_RULES_LOGIN);

        // $pw = bcrypt($request->get('password'));
        // dd($pw);

        if (Auth::attempt($request->only('email', 'password'), (bool) $request->get('rememberMe'))) {
            return redirect()->route('home');
        }

        return back()->withInput()->withErrors([
            'login' => 'Неверная комбинация адреса эл. почты и пароля.',
            'email' => 'Возможно, вы указали неверный адрес эл. почты',
            'password' => 'Возможно, вы указали неверный пароль',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
