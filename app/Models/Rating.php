<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings'; // 表名
    protected $primaryKey = 'RatingID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'RatingID',
        'PlayerID',
        'GameID',
        'RatingMark',
        'RatingWeight',
        'RatingText',
        'RatingImageURL',
        'RatingVideoURL',
        'RatingTime',
        'TotalLikeReceived',
        'PlayerLevel', // 确保 PlayerLevel 可以批量赋值
    ];

    // 启用模型事件钩子
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rating) {
            // 自动生成 RatingID
            if (!$rating->RatingID) {
                $lastRating = Rating::orderBy('RatingID', 'desc')->first();
                $newIdNumber = $lastRating ? ((int) substr($lastRating->RatingID, 2)) + 1 : 1;
                $rating->RatingID = 'RT' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
            }

            // 自动填充 PlayerLevel
            if ($rating->PlayerID) {
                $player = \App\Models\Player::find($rating->PlayerID);
                if ($player) {
                    $rating->PlayerLevel = $player->PlayerLevel;
                }
            }
        });

        static::saved(function ($rating) {
            $game = $rating->game;
            if ($game) {
                $rating->updateRatingScore();
            }
        });

        static::deleted(function ($rating) {
            $game = $rating->game;
            if ($game) {
                $rating->updateRatingScore();
            }
        });
    }

    // 定义与 Player 模型的关系
    public function player()
    {
        return $this->belongsTo(Player::class, 'PlayerID', 'PlayerID');
    }

    

    // 定义与 Game 模型的关系
    public function game()
    {
        return $this->belongsTo(Game::class, 'GameID', 'GameID');
    }

    public function likes()
    {
        return $this->hasMany(RatingLike::class, 'RatingID', 'RatingID');
    }

    public function updateRatingScore()
    {
        $game = $this->game; // 获取当前评分所属的游戏
        if (!$game) {
            return; // 如果没有关联游戏，则直接返回
        }

        $ratings = $game->ratings; // 获取该游戏的所有评分
        $totalScore = 0;

        foreach ($ratings as $rating) {
            $playerLevel = $rating->PlayerLevel;
            $isRecommended = $rating->RatingMark;

            // 计算分数
            if ($isRecommended) {
                switch ($playerLevel) {
                    case 2:
                        $totalScore += 1;
                        break;
                    case 3:
                        $totalScore += 3;
                        break;
                    case 4:
                        $totalScore += 10;
                        break;
                    case 5:
                        $totalScore += 30;
                        break;
                }
            }
        }

        // 更新游戏的评分总分字段
        $game->RatingScore = $totalScore;
        $game->save();
    }



}
