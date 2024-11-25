<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;  //import model
use Illuminate\Support\Facades\Hash; //???????
use Illuminate\Support\Facades\Auth; //????????

class PlayerController extends Controller
{
    public function showLoginForm()
    {
        return view('player-login');
    }

    public function showRegisterForm()
    {
        return view('player-register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('PlayerEmail', 'PlayerPW');

        if (Auth::guard('player')->attempt(['PlayerEmail' => $credentials['PlayerEmail'], 'PlayerPW' => $credentials['PlayerPW']])) {
            $request->session()->regenerate();
            return redirect()->route('welcome')->with('success', 'Login successful');
        }

        return back()->withErrors(['PlayerEmail' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'PlayerName' => 'required|string|max:255',
            'PlayerEmail' => 'required|email|unique:players,PlayerEmail',
            'PlayerPW' => 'required|string|min:8|confirmed',
        ]);

        $player = new Player([
            'PlayerName' => $request->PlayerName,
            'PlayerEmail' => $request->PlayerEmail,
            'PlayerPW' => Hash::make($request->PlayerPW),
        ]);
        $player->save();

        return redirect()->route('player.login')->with('success', 'Registration successful');
    }

    public function home()
    {
        $player = Player::all();
        return view('home', ['player' => $player]);

    }

    //public function dashboard()
    //{
    //    if (Auth::check()) {
    //        // 用户已登录
    //        $user = Auth::user();  // 获取当前登录的用户
    //        return view('dashboard', ['user' => $user]); // 将用户信息传递给视图
    //    } else {
    //        // 用户没有登录
    //        return redirect()->route('login')->with('message', 'Please log in first.');
    //    }
    //}
}
