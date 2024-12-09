<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;


class RatingController extends Controller
{
    public function store(Request $request, $gameID)
    {
        $request->validate([
            'RatingMark' => 'required|boolean',
            'RatingText' => 'nullable|string|max:1000',
        ]);

        $playerID = Auth::guard('player')->user()->PlayerID;  //$playerID = Auth::guard('player')->id();

        // 检查是否已评价
        $existingRating = Rating::where('PlayerID', $playerID)->where('GameID', $gameID)->first();

        if ($existingRating) {
            return redirect()->route('game.detail', ['game' => $gameID])
                ->withErrors('You have already rated this game.');
        }

        // 创建评价
        Rating::create([
            'PlayerID' => $playerID,
            'GameID' => $gameID,
            'RatingMark' => $request->input('RatingMark'),
            'RatingText' => $request->input('RatingText'),
            'RatingTime' => now(),
        ]);

        return redirect()->route('game.detail', ['game' => $gameID])
            ->with('success', 'Your rating has been submitted successfully.');
    }
    public function destroy($ratingID)
    {
        $rating = Rating::findOrFail($ratingID);
        $rating->delete();

        return back()->with('success', 'Rating deleted successfully.');
    }

    public function like($ratingID)
    {
        $rating = Rating::findOrFail($ratingID);
        $playerID = Auth::guard('player')->user()->PlayerID;

        // 检查是否已点赞
        $existingLike = $rating->likes()->where('PlayerID', $playerID)->first();

        if ($existingLike) {
            return back()->withErrors('You have already liked this rating.');
        }

        // 增加点赞记录
        $rating->likes()->create([
            'PlayerID' => $playerID,
        ]);

        // 增加点赞数量
        $rating->increment('TotalLikeReceived');

        // 检查是否需要给玩家增加分数
        if ($rating->TotalLikeReceived == 100) {
            $player = Player::find($rating->PlayerID);
            if ($player) {
                $player->increment('PlayerScore');
                $player->updatePlayerLevel(); // 可选：更新玩家等级
            }
        }

        return back()->with('success', 'You liked this rating!');
    }
}
