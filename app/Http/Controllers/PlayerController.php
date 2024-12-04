<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;  //import model
use Illuminate\Support\Facades\Hash; //???????
use Illuminate\Support\Facades\Auth; //????????

class PlayerController extends Controller
{
        public function home()
    {
        $player = Player::all();
        return view('home', ['player' => $player]);

    }

}
