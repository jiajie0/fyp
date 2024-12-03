<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
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

    public function edit($ratingID)
    {
        $rating = Rating::findOrFail($ratingID);
        return view('rating.edit', compact('rating'));
    }

    public function update(Request $request, $ratingID)
    {
        $data = $request->validate([
            'RatingMark' => 'required|boolean',
            'RatingText' => 'nullable|string|max:1000',
        ]);

        $rating = Rating::findOrFail($ratingID);
        $rating->update($data);

        return redirect()->route('game.detail', $rating->GameID)->with('success', 'Rating updated successfully.');
    }

    public function destroy($ratingID)
    {
        $rating = Rating::findOrFail($ratingID);
        $rating->delete();

        return back()->with('success', 'Rating deleted successfully.');
    }
}
