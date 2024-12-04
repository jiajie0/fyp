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

}
