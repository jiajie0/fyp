<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;// 定义了进行身份验证所需的基础方法,便于module使用 Laravel 的身份验证功能

class Player extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;  // 使用 AuthenticatableTrait 来实现认证功能

    protected $table = 'players';  // 如果使用默认的命名规则可以省略此行
    protected $primaryKey = 'PlayerID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($player) {
            // 如果没有 PlayerID 则生成
            if (!$player->PlayerID) {
                // 查找最后一位 PlayerID
                $lastPlayer = Player::orderBy('PlayerID', 'desc')->first();

                // 如果有记录，处理 ID
                if ($lastPlayer) {
                    $lastIdNumber = (int) substr($lastPlayer->PlayerID, 2);
                    $newIdNumber = $lastIdNumber + 1;
                } else {
                    $newIdNumber = 1; // 没有记录，从 1 开始
                }

                // 生成新 PlayerID，格式为 "PY" + 补零后的数字
                $player->PlayerID = 'PY' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
            }
        });
    }

    protected $fillable = [
        'PlayerID',
        'PlayerName',
        'PlayerPW',
        'TotalRatingNumber',
        'TotalPlayTime',
        'TotalLikeReceived',
        'PlayerScore',
        'PlayerEmail',
    ];

    // one player can have many post
    public function posts()
    {
        return $this->hasMany(Post::class, 'PlayerID', 'PlayerID');
    }

    // one player Rating
    public function rating()
    {
        return $this->hasOne(Rating::class, 'PlayerID', 'PlayerID');
    }

    // 多对多的关系，一个玩家可以参与多个游戏，通过 game_store
    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_store', 'PlayerID', 'GameID')
            ->withPivot('GameAchievementsCount', 'PlayerAchievementsCount', 'TotalPlayTime')
            ->withTimestamps();
    }

    public function getAuthIdentifier()
    {
        return $this->PlayerID; // 返回主键字段的值
    }
}
