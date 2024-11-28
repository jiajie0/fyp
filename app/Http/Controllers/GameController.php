<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;  //import model
use App\Models\Developer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;  //生成一个更长、更随机的字符串，从而避免文件名冲突：


class GameController extends Controller
{
    public function index()
    {
        $game = Game::all();
        return view('game.index', ['game' => $game]);

    }
    public function create()
    {
        $developerID = Auth::guard('developer')->user()->DeveloperID;
        return view('game.create', compact('developerID'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'DeveloperID' => 'required|exists:developers,DeveloperID',
            'GameName' => 'required|string|max:255',
            'GameDescription' => 'nullable|string',
            'GameCategory' => 'required|string|max:255',
            'GamePrice' => 'required|numeric|min:0',
            'GameAchievementsCount' => 'nullable|integer|min:0',
            'GameAvatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 检查并处理文件上传
        if ($request->hasFile('GameAvatar')) {
            $file = $request->file('GameAvatar');
            $randomFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

            // 使用 move() 将文件移动到指定目录
            $destinationPath = storage_path('app/public/games/GameAvatar');  // 设置目标路径
            $file->move($destinationPath, $randomFileName);  // 移动文件

            // 保存文件路径到数据库
            $data['GameAvatar'] = 'storage/games/GameAvatar/' . $randomFileName;  // 这里返回的是相对于 public 目录的路径

            // 检查文件是否成功存储
            // $fullPath = $destinationPath . '\\' . $randomFileName;
            // dd([
            //     'file_name' => $randomFileName,
            //     'storage_path' => $fullPath,
            //     'exists_in_storage' => file_exists($fullPath),  // 检查文件是否存在
            // ]);
        }

        // 设置 GameUploadDate 为当前日期
        $data['GameUploadDate'] = now()->toDateString();

        // 如果 GameDescription 为 null, 设置为空字符串
        $data['GameDescription'] = $data['GameDescription'] ?? '';

        // 创建新的游戏记录
        $newGame = Game::create($data);

        return redirect(route('game.index'))->with('success', 'Game created successfully!');
    }


    public function edit(Game $game)
    {
        //dd($game); dump and die
        return view('game.edit', ['game' => $game]);
    }

    public function update(Game $game, Request $request)
    {
        $data = $request->validate([
            'DeveloperID' => 'required|exists:developers,DeveloperID',  // 验证 DeveloperID 是否存在于开发者表中
            'GameName' => 'required|string|max:255',
            'GameDescription' => 'nullable|string',
            'GameCategory' => 'required|string|max:255',
            'GamePrice' => 'required|numeric|min:0',
            'GameAchievementsCount' => 'nullable|integer|min:0',
            'GameAvatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 设置 GameUploadDate 为当前日期
        $data['GameUploadDate'] = now()->toDateString();  //toDateString() 会以 'YYYY-MM-DD' 格式返回


        // 如果 GameDescription 为 null, 设置为空字符串
        $data['GameDescription'] = $data['GameDescription'] ?? '';

        // 处理头像上传
        if ($request->hasFile('GameAvatar')) {
            if ($game->GameAvatar) {
                // 删除旧头像
                $oldGameAvatarPath = str_replace('/storage', 'public/storage', $game->GameAvatar);
                Storage::delete($oldGameAvatarPath);
            }

            $file = $request->file('GameAvatar');
            $path = $file->storeAs(
                'public/games/GameAvatar',
                Str::random(40) . '.' . $file->getClientOriginalExtension()  // 使用原始文件的扩展名
            );
            $data['GameAvatar'] = Storage::url($path);
        }

        $game->update($data);

        return redirect(route('game.index'))->with('success', 'Game update succesffuly');
    }

    public function delete(Game $game)
    {
        if ($game->GameAvatar) {
            // 删除旧头像
            Storage::delete(str_replace('/storage', 'public', $game->GameAvatar));  // 确保路径格式正确
        }

        // 删除游戏记录
        $game->delete();

        // 重定向并显示成功消息
        return redirect(route('game.index'))->with('success', 'Game deleted successfully');
    }

    public function showWelcomePage()
    {
        $game = Game::select('GameID', 'GameName', 'GameAvatar')->get();
        return view('welcome', ['game' => $game]);
    }

    public function showGameDetails(Game $game)
    {
        $developerName = $game->developer->DeveloperName;
        return view('game.detail', [
            'game' => $game,
            'developerName' => $developerName, // 将开发者名字传递到视图
        ]);
    }

    public function addToGameStore(Request $request, $gameID)
    {
        // 获取当前登录的玩家 ID
        $playerID = Auth::guard('player')->id();

        // 检查是否已添加过该游戏
        $exists = \App\Models\GameStore::where('PlayerID', $playerID)
            ->where('GameID', $gameID)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This game is already in your store!');
        }

        // 添加到游戏商店
        \App\Models\GameStore::create([
            'PlayerID' => $playerID,
            'GameID' => $gameID,
            'GameAchievementsCount' => 0,
            'PlayerAchievementsCount' => 0,
            'TotalPlayTime' => 0,
        ]);

        return redirect()->back()->with('success', 'Game added to your store successfully!');
    }

}
