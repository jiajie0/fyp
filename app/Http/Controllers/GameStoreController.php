<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameStore;  //import model
use App\Models\Developer;
use App\Models\Game;
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

        // 获取游戏的 GameAchievementsCount
        $game = Game::find($gameID);
        if (!$game) {
            return redirect()->back()->with('error', 'Game not found!');
        }
        $gameAchievementsCount = $game->GameAchievementsCount;

        // 添加到游戏商店
        GameStore::create([
            'PlayerID' => $playerID,
            'GameID' => $gameID,
            'GameAchievementsCount' => $gameAchievementsCount,
            'PlayerAchievementsCount' => 0,
            'TotalPlayTime' => 0,
        ]);

        return redirect()->back()->with('success', 'Game added to your store successfully!');
    }

    public function addPlayTime(Request $request, $gameId)
    {
        // 获取当前登录玩家
        $player = Auth::guard('player')->user();

        if (!$player) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 调用 Player 模型中的 addPlayTimeScore 方法
        $updateResult = $player->addPlayTimeScore($gameId, 1); // 增加 1 小时游玩时间

        if (!$updateResult) {
            return redirect()->back()->with('error', 'Game not found or not in your store.');
        }

        return redirect()->back()->with('success', 'Play time and score updated successfully.');
    }

    // public function addAchievementsCount(Request $request, $gameId)
    // {
    //     // 获取当前登录玩家
    //     $player = Auth::guard('player')->user();

    //     if (!$player) {
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }

    //     // 查找玩家与游戏的中间表记录
    //     $gameStore = $player->games()->where('game_store.GameID', $gameId)->first();

    //     if (!$gameStore) {
    //         return redirect()->back()->with('error', 'Game not found or not in your store.');
    //     }

    //     // 增加 PlayerAchievementsCount
    //     $currentAchievementsCount = $gameStore->pivot->PlayerAchievementsCount;
    //     $player->games()->updateExistingPivot($gameId, [
    //         'PlayerAchievementsCount' => $currentAchievementsCount + 1,
    //     ]);

    //     // 更新分数逻辑
    //     $player->updateScoreForAchievements($gameId);

    //     return redirect()->back()->with('success', 'Achievements count and score updated successfully.');
    // }

    public function addAchievementsCount(Request $request, $gameId)
    {
        // 获取当前登录玩家
        $player = Auth::guard('player')->user();

        if (!$player) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 查找玩家与游戏的中间表记录
        $gameStore = $player->games()->where('game_store.GameID', $gameId)->first();

        if (!$gameStore) {
            return redirect()->back()->with('error', 'Game not found or not in your store.');
        }

        // 增加 PlayerAchievementsCount
        $currentAchievementsCount = $gameStore->pivot->PlayerAchievementsCount;
        $player->games()->updateExistingPivot($gameId, [
            'PlayerAchievementsCount' => $currentAchievementsCount + 1,
        ]);

        // 重新加载数据以确保数据最新
        $gameStore = $player->games()->where('game_store.GameID', $gameId)->first();

        // 更新分数逻辑
        $player->updateScoreForAchievements($gameId);

        return redirect()->back()->with('success', 'Achievements count and score updated successfully.');
    }


}
