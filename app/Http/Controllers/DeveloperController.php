<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Developer;  //import model
use Illuminate\Support\Facades\Hash; //???????
use Illuminate\Support\Facades\Auth; //????????

class DeveloperController extends Controller
{
    public function home()
    {
        if (!Auth::user() || !Auth::user() instanceof Developer) {
            abort(403, 'Unauthorized access.');
        }

        return view('developer-home');
    }
    public function showLoginForm()
    {
        return view('developer-login');
    }

    public function showRegisterForm()
    {
        return view('developer-register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('DeveloperEmail', 'DeveloperPW');

        if (Auth::guard('developer')->attempt(['DeveloperEmail' => $credentials['DeveloperEmail'], 'DeveloperPW' => $credentials['DeveloperPW']])) {
            $request->session()->regenerate();
            return redirect()->route('developer.home')->with('success', 'Login successful');
        }

        return back()->withErrors(['DeveloperEmail' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'DeveloperName' => 'required|string|max:255',
            'DeveloperEmail' => 'required|email|unique:developers,DeveloperEmail',
            'DeveloperPW' => 'required|string|min:8|confirmed',
        ]);

        $developer = new Developer([
            'DeveloperName' => $request->DeveloperName,
            'DeveloperEmail' => $request->DeveloperEmail,
            'DeveloperPW' => Hash::make($request->DeveloperPW),
        ]);
        $developer->save();

        return redirect()->route('developer.login')->with('success', 'Registration successful');
    }
}
