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

    public function updatePlayerScore(Request $request)
    {
        $playerId = $request->input('PlayerID');
        $gameId = $request->input('GameID');
        $playTimeHours = $request->input('PlayTimeHours');

        $player = Player::find($playerId);

        if (!$player) {
            return response()->json(['message' => 'Player not found'], 404);
        }

        $success = $player->addPlayTimeScore($gameId, $playTimeHours);

        if ($success) {
            return response()->json(['message' => 'Player score updated successfully']);
        } else {
            return response()->json(['message' => 'Player has not played this game'], 400);
        }
    }

}
