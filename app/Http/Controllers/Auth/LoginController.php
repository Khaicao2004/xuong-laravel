<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function showFormLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // dd($credentials);    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            if(Auth::user()->isAdmin()){
                return redirect('/admin');
            }
            return redirect()->intended('/home');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout()
    {
        Auth::logout();
        \request()->session()->invalidate();
        return redirect('/');
    }
}
