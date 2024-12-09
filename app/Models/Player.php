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

    public function addPlayTimeScore($gameId, $additionalPlayTimeHours)
    {
        // 获取玩家和游戏的中间记录
        $gameStore = $this->games()
            ->where('game_store.GameID', $gameId) // 显式指定 game_store 表
            ->first();

        if (!$gameStore) {
            return false; // 玩家尚未游玩此游戏
        }

        // 获取当前的游玩时间
        $currentPlayTime = $gameStore->pivot->TotalPlayTime;

        // 计算新增加的总游玩时间
        $newPlayTime = $currentPlayTime + $additionalPlayTimeHours;

        // 计算当前总得分（以时间为基础，每小时 1 分，最大 15 分）
        $currentScore = min((int) ($currentPlayTime), 15);
        $newScore = min((int) ($newPlayTime), 15);

        // 更新 PlayerScore 只增加新增分数部分
        $scoreToAdd = $newScore - $currentScore;

        // 更新 game_store 表中的 TotalPlayTime
        $this->games()->updateExistingPivot($gameId, ['TotalPlayTime' => $newPlayTime]);

        // 更新玩家总分
        $this->PlayerScore += $scoreToAdd;
        $this->save();

        // 自动更新玩家等级
        $this->updatePlayerLevel();

        return true; // 更新成功
    }

    public function updateScoreForAchievements($gameId)
    {
        // 重新加载玩家和游戏的中间记录以确保最新数据
        $gameStore = $this->games()
            ->where('game_store.GameID', $gameId)
            ->first();

        if (!$gameStore) {
            return false; // 玩家尚未游玩此游戏
        }
        $gameStore = $this->games()->where('game_store.GameID', $gameId)->first();
        // 通过 pivot 属性获取中间表中的最新数据
        $playerAchievements = $gameStore->pivot->PlayerAchievementsCount;
        $gameAchievements = $gameStore->pivot->GameAchievementsCount;
        $has50PercentScore = $gameStore->pivot->Has50PercentScore;
        $has80PercentScore = $gameStore->pivot->Has80PercentScore;

        if ($gameAchievements <= 0) {
            return false; // 防止除以零错误
        }

        // 计算成就百分比
        $achievementPercentage = ($playerAchievements / $gameAchievements) * 100;
        $scoreToAdd = 0;

        // 检查是否已经为 50% 成就加过分数
        if ($has50PercentScore == 0 && $achievementPercentage >= 50) {
            $scoreToAdd += 1; // 增加 1 分
            $this->games()->updateExistingPivot($gameId, ['Has50PercentScore' => 1]);

            // 重新加载最新数据
            $gameStore = $this->games()->where('game_store.GameID', $gameId)->first();
            $has80PercentScore = $gameStore->pivot->Has80PercentScore; // 确保最新状态
        }

        // 检查是否已经为 80% 成就加过分数
        if ($has80PercentScore == 0 && $achievementPercentage >= 80) {
            $scoreToAdd += 2; // 增加 2 分
            $this->games()->updateExistingPivot($gameId, ['Has80PercentScore' => 1]);
        }

        // 仅当有分数变化时更新 PlayerScore
        if ($scoreToAdd > 0) {
            $this->increment('PlayerScore', $scoreToAdd); // 增加 PlayerScore
            $this->updatePlayerLevel(); // 更新玩家等级
        }

        return true;
    }


    public function updatePlayerLevel()
    {
        $score = $this->PlayerScore;

        if ($score <= 10) {
            $this->PlayerLevel = 1;
        } elseif ($score <= 50) {
            $this->PlayerLevel = 2;
        } elseif ($score <= 200) {
            $this->PlayerLevel = 3;
        } elseif ($score <= 500) {
            $this->PlayerLevel = 4;
        } else {
            $this->PlayerLevel = 5;
        }

        $this->save();
    }
}
