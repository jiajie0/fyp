<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Staff;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    // show player login page
    public function showPlayerLogin()
    {
        return view('auth.player-login');
    }

    // player Login logic
    public function playerLogin(Request $request)
    {
        $validatedData = $request->validate([
            'PlayerEmail' => 'required|email',
            'PlayerPW' => 'required|string|min:8',
        ]);

        $player = Player::where('PlayerEmail', $validatedData['PlayerEmail'])->first();

        if ($player && Hash::check($validatedData['PlayerPW'], $player->PlayerPW)) {
            Auth::guard('player')->login($player);
            $request->session()->regenerate();
            return redirect()->route('welcome')->with('success', 'Login successful');
        }

        return back()->withErrors(['PlayerEmail' => 'Invalid email or password.'])->withInput();
    }

    // show player register page
    public function showPlayerRegister()
    {
        return view('auth.player-register');
    }

    // player register logic
    public function playerRegister(Request $request)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'PlayerName' => 'required|string|max:255',
            'PlayerPW' => 'required|string|min:8|confirmed',
            'PlayerEmail' => 'required|email|unique:players,PlayerEmail',
        ]);

        // 对密码进行加密处理
        $validatedData['PlayerPW'] = Hash::make($validatedData['PlayerPW']);

        // 创建玩家
        Player::create([
            'PlayerName' => $validatedData['PlayerName'],
            'PlayerPW' => $validatedData['PlayerPW'],
            'PlayerEmail' => $validatedData['PlayerEmail'],
        ]);

        // 注册成功后重定向到登录页面
        return redirect()->route('player.login')->with('success', 'Player registered successfully');
    }



    // show developer login page
    public function showDeveloperLogin()
    {
        return view('auth.developer-login');
    }

    // developer Login logic
    public function developerLogin(Request $request)
    {
        $validatedData = $request->validate([
            'DeveloperEmail' => 'required|email',
            'DeveloperPW' => 'required|string|min:8',
        ]);

        $developer = Developer::where('DeveloperEmail', $validatedData['DeveloperEmail'])->first();

        if ($developer && Hash::check($validatedData['DeveloperPW'], $developer->DeveloperPW)) {
            Auth::guard('developer')->login($developer);
            $request->session()->regenerate();
            return redirect()->route('developer.home')->with('success', 'Login successful');
        }

        return back()->withErrors(['DeveloperEmail' => 'Invalid email or password.'])->withInput();
    }

    // show developer Register page
    public function showDeveloperRegister()
    {
        return view('auth.developer-register');
    }

    // developer Register logic
    public function developerRegister(Request $request)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'DeveloperName' => 'required|string|max:255',
            'DeveloperPW' => 'required|string|min:8|confirmed',
            'DeveloperEmail' => 'required|email|unique:developers,DeveloperEmail',
            'CompanyName' => 'required|string|max:255',
        ]);

        // 对密码进行加密处理
        $validatedData['DeveloperPW'] = Hash::make($validatedData['DeveloperPW']);

        // 创建开发者
        Developer::create([
            'DeveloperName' => $validatedData['DeveloperName'],
            'DeveloperPW' => $validatedData['DeveloperPW'],
            'DeveloperEmail' => $validatedData['DeveloperEmail'],
            'CompanyName' => $validatedData['CompanyName'],
        ]);

        // 注册成功后重定向到登录页面
        return redirect()->route('developer.login')->with('success', 'Developer registered successfully');
    }

//99999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
    // show staff login page
    public function showStaffLogin()
    {
        return view('auth.staff-login');
    }

    // staff Login logic
    public function staffLogin(Request $request)
    {
        $validatedData = $request->validate([
            'StaffEmail' => 'required|email',
            'StaffPW' => 'required|string|min:8',
        ]);

        $staff = Staff::where('StaffEmail', $validatedData['StaffEmail'])->first();

        if ($staff && Hash::check($validatedData['StaffPW'], $staff->StaffPW)) {
            Auth::guard('staff')->login($staff);
            $request->session()->regenerate();
            return redirect()->route('staff.home')->with('success', 'Login successful');
        }

        return back()->withErrors(['StaffEmail' => 'Invalid email or password.'])->withInput();
    }

    // show staff Register page
    public function showStaffRegister()
    {
        return view('auth.staff-register');
    }

    // staff Register logic
    public function staffRegister(Request $request)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'StaffName' => 'required|string|max:255',
            'StaffPW' => 'required|string|min:8|confirmed',
            'StaffEmail' => 'required|email|unique:staff,StaffEmail',//原本加s
        ]);

        // 对密码进行加密处理
        $validatedData['StaffPW'] = Hash::make($validatedData['StaffPW']);

        // 创建开发者
        Staff::create([
            'StaffName' => $validatedData['StaffName'],
            'StaffPW' => $validatedData['StaffPW'],
            'StaffEmail' => $validatedData['StaffEmail'],
        ]);

        // 注册成功后重定向到登录页面
        return redirect()->route('staff.login')->with('success', 'Staff registered successfully');
    }
//99999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
    public function logout(Request $request)
    {
        // 检查是否有 'action' 参数，且值为 'destroy'
        if ($request->has('action') && $request->input('action') === 'destroy') {
            // 登出 web 用户
            Auth::guard('web')->logout();

            // 清空所有会话数据并重生令牌
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Logged out successfully!');
        }

        // 根据当前认证守卫登出相应用户
        if (Auth::guard('staff')->check()) {
            Auth::guard('staff')->logout();

            // 清空会话数据并重生令牌
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('staff.login')->with('success', 'Logged out successfully!');
        }

        // 如果没有指定具体守卫，则登出所有用户
        Auth::guard('web')->logout();
        Auth::guard('staff')->logout();
        Auth::guard('player')->logout();
        Auth::guard('staff')->logout();

        // 清空会话数据并重生令牌
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
    }

}
