<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 导入 Auth

class DeveloperController extends Controller
{
    public function home()
    {
        // 检查用户是否通过开发者守卫认证
        if (!Auth::guard('developer')->check()) {
            return redirect()->route('developer.login')->withErrors('Please log in as a developer.');
        }

        // 如果认证通过，返回开发者主页视图
        return view('developer-home');
    }
}
