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

        // 尝试使用自定义守卫验证
        if (
            Auth::guard('player')->attempt([
                'PlayerEmail' => $validatedData['PlayerEmail'],
                'password' => $validatedData['PlayerPW']])) {
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

        // 使用自定义守卫进行认证
        if (
            Auth::guard('developer')->attempt([
                'DeveloperEmail' => $validatedData['DeveloperEmail'],
                'password' => $validatedData['DeveloperPW']
            ])
        ) {
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


    // show staff login page
    public function showStaffLogin()
    {
        return view('auth.staff-login');
    }

    // staff login logic
    public function staffLogin(Request $request)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'StaffEmail' => 'required|email',
            'StaffPW' => 'required|string|min:8',
        ]);

        // 尝试使用提供的邮箱和密码进行认证
        $staff = Staff::where('StaffEmail', $validatedData['StaffEmail'])->first();

        // 检查玩家是否存在并且密码是否正确
        // 使用自定义守卫进行认证
        if (Auth::guard('staff')->attempt(['StaffEmail' => $validatedData['StaffEmail'], 'password' => $validatedData['StaffPW']])) {
            $request->session()->regenerate();
            return redirect()->route('staff.home')->with('success', 'Login successful');
        }

        // 登录失败，返回错误信息
        return back()->withErrors(['StaffEmail' => 'Invalid email or password.'])->withInput();
    }

    // show staff register page
    public function showStaffRegister()
    {
        return view('auth.staff-register');
    }

    // staff register logic
    public function staffRegister(Request $request)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'StaffName' => 'required|string|max:255', // 字段名保持与数据库一致
            'StaffPW' => 'required|string|min:8|confirmed',
            'StaffEmail' => 'required|email|unique:staff,StaffEmail',
        ]);

        // 对密码进行加密处理
        $validatedData['StaffPW'] = Hash::make($validatedData['StaffPW']);

        // 创建员工
        Staff::create([
            'StaffName' => $validatedData['StaffName'],
            'StaffPW' => $validatedData['StaffPW'],
            'StaffEmail' => $validatedData['StaffEmail'],
        ]);

        // 注册成功后重定向到登录页面
        return redirect()->route('staff.login')->with('success', 'Staff registered successfully');
    }

    // public function logout(Request $request)
    // {
    //     // 确保登出开发者
    //     Auth::guard('developer')->logout();

    //     // 清理会话
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     // 重定向到登录页面
    //     return redirect()->route('developer.login')->with('success', 'Logged out successfully!');
    // }

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
        if (Auth::guard('developer')->check()) {
            Auth::guard('developer')->logout();

            // 清空会话数据并重生令牌
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('developer.login')->with('success', 'Logged out successfully!');
        }

        // 如果没有指定具体守卫，则登出所有用户
        Auth::guard('web')->logout();
        Auth::guard('developer')->logout();
        Auth::guard('player')->logout();
        Auth::guard('staff')->logout();

        // 清空会话数据并重生令牌
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
    }

}
