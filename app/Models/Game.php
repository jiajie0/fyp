<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Game extends Model
{
    //通常，Laravel 会将模型类名转换为小写复数形式作为表名。例如，Player 类会默认对应一个名为 players
    //例如，Player 类会默认对应一个名为 players的数据库表，Post 类则对应 posts 表，等等。
    protected $table = 'games';  // 如果database遵循这种命名规则，可以删除这行
    protected $primaryKey = 'GameID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'GameReferenceImages' => 'array', // 自动处理 JSON 字段为数组
    ];
    

    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            // 如果没有 GameID 则生成
            if (!$game->GameID) {
                // 查找最后一位 GameID
                $lastGame = Game::orderBy('GameID', 'desc')->first();

                // 如果有记录，处理 ID
                if ($lastGame) {
                    $lastIdNumber = (int) substr($lastGame->GameID, 2);
                    $newIdNumber = $lastIdNumber + 1;
                } else {
                    $newIdNumber = 1; // 没有记录，从 1 开始
                }

                // 生成新 GameID，格式为 "GM" + 补零后的数字
                $game->GameID = 'GM' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
            }
        });
    }


    protected $fillable = [
        'DeveloperID',
        'GameName',
        'GameDescription',
        'GameCategory',
        'GamePrice',
        'GameAchievementsCount',
        'GameAvatar',
        'GameReferenceImages'
    ];

    // 游戏与开发者之间的关系：一个开发者可以开发多个游戏
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'DeveloperID', 'DeveloperID');
    }

    // 游戏和玩家之间的关系：一个游戏可以被多个玩家通过 game_store 表关联
    public function players()
    {
        return $this->belongsToMany(Player::class, 'game_store', 'GameID', 'PlayerID')
            ->withPivot('GameAchievementsCount', 'PlayerAchievementsCount', 'TotalPlayTime')
            ->withTimestamps();
    }

    // 游戏与评分之间的关系：一个游戏可能有多个评分
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'GameID', 'GameID');
    }


}
