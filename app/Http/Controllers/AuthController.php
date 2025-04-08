<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        session(['user' => $user]);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/employee/dashboard');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/login');
    }
}