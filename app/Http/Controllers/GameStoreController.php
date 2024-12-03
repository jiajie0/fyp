<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameStore;  //import model
use App\Models\Developer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class GameStoreController extends Controller
{
    public function index()
    {
        // 确保玩家登录
        if (Auth::guard('player')->check()) {
            $playerID = Auth::guard('player')->user()->PlayerID;

            // Eager load the 'game' relationship to get the related game data
            $game_store = GameStore::where('PlayerID', $playerID)
                ->with('game')  // Eager load the related 'game' data
                ->get();

            return view('game_store.gamestore', ['game_store' => $game_store]);
        } else {
            return redirect()->route('player.login')->with('error', 'Please log in first');
        }
    }

    public function delete($playerID, $gameID)
    {
        // 查询要删除的记录
        $game_store = GameStore::where('PlayerID', $playerID)
            ->where('GameID', $gameID)
            ->first();

        // 检查记录是否存在
        if (!$game_store) {
            return redirect()->back()->with('error', 'Game not found');
        }

        // 删除关联文件
        if (!empty($game_store->GameAvatar) && Storage::exists(str_replace('/storage', 'public', $game_store->GameAvatar))) {
            Storage::delete(str_replace('/storage', 'public', $game_store->GameAvatar));
        }

        // 显式删除记录
        GameStore::where('PlayerID', $playerID)
            ->where('GameID', $gameID)
            ->delete();

        // 返回成功消息
        return redirect()->route('game_store.index')->with('success', 'Game deleted successfully');
    }

    public function addToGameStore(Request $request, $gameID)
    {
        $playerID = Auth::guard('player')->id();

        // 检查是否已添加过该游戏
        $exists = GameStore::where('PlayerID', $playerID)
            ->where('GameID', $gameID)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This game is already in your store!');
        }

        // 添加到游戏商店
        GameStore::create([
            'PlayerID' => $playerID,
            'GameID' => $gameID,
            'GameAchievementsCount' => 0,
            'PlayerAchievementsCount' => 0,
            'TotalPlayTime' => 0,
        ]);

        return redirect()->back()->with('success', 'Game added to your store successfully!');
    }

}
