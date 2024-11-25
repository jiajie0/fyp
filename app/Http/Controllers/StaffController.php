<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;  //import model
use Illuminate\Support\Facades\Hash; //???????
use Illuminate\Support\Facades\Auth; //????????

class StaffController extends Controller
{
    public function home()
    {
        if (!Auth::user() || !Auth::user() instanceof Staff) {
            abort(403, 'Unauthorized access.');
        }

        return view('staff-home');
    }
    public function showLoginForm()
    {
        return view('auth.staff-login'); //要注意路径要一样
    }

    public function showRegisterForm()
    {
        return view('staff-register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('StaffEmail', 'StaffPW');

        if (Auth::guard('staff')->attempt(['StaffEmail' => $credentials['StaffEmail'], 'StaffPW' => $credentials['StaffPW']])) {
            $request->session()->regenerate();
            return redirect()->route('staff.home')->with('success', 'Login successful');
        }

        return back()->withErrors(['StaffEmail' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'StaffName' => 'required|string|max:255',
            'StaffEmail' => 'required|email|unique:staff,StaffEmail',
            'StaffPW' => 'required|string|min:8|confirmed',
        ]);

        $staff = new Staff([
            'StaffName' => $request->StaffName,
            'StaffEmail' => $request->StaffEmail,
            'StaffPW' => Hash::make($request->StaffPW),
        ]);
        $staff->save();

        return redirect()->route('staff.login')->with('success', 'Registration successful');
    }
    public function index()
    {
        $staff = Staff::all();
        return view('staff.index', ['staff' => $staff]);

    }
    public function create()
    {
        return view('staff.create');
    }
    public function store(Request $request)
    {
        //dd($request->name);        //Dump and Die"（转储并终止）。dd() 在输出变量的详细信息之后，会停止脚本的执行。它通常用于调试时查看数据并确保程序在某一点停止执行。
        $data = $request->validate([
            'StaffName' => 'required|string|max:255',
            'StaffEmail' => 'required|email|unique:staff,StaffEmail',
            'StaffPW' => 'required|string|min:8|confirmed',
        ]);

        $newStaff = Staff::create($data);

        return redirect(route('staff.index'));

    }
    public function edit(Staff $staff)
    {
        //dd($staff); dump and die
        return view('staff.edit', ['staff' => $staff]);
    }

    public function update(Staff $staff, Request $request)
    {
        $data = $request->validate([
            'StaffName' => 'required|string|max:255',
            'StaffEmail' => 'required|email|unique:staff,StaffEmail',
            'StaffPW' => 'required|string|min:8',
        ]);

        $staff->update($data);

        return redirect(route('staff.index'))->with('success', 'Staff update succesffuly');
    }

    public function delete(Staff $staff)
    {
        $staff->delete();
        return redirect(route('staff.index'))->with('success', 'Staff deleted succesffuly');
    }
}
