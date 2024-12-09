<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rating extends Model
{
    //通常，Laravel 会将模型类名转换为小写复数形式作为表名。例如，Player 类会默认对应一个名为 players
    //例如，Player 类会默认对应一个名为 players的数据库表，Post 类则对应 posts 表，等等。
    protected $table = 'ratings';  // 如果database遵循这种命名规则，可以删除这行

    protected $primaryKey = 'RatingID';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rating) {
            // 如果没有 RatingID 则生成
            if (!$rating->RatingID) {
                // 查找最后一位 RatingID
                $lastRating = Rating::orderBy('RatingID', 'desc')->first();

                // 如果有记录，处理 ID
                if ($lastRating) {
                    $lastIdNumber = (int) substr($lastRating->RatingID, 2);
                    $newIdNumber = $lastIdNumber + 1;
                } else {
                    $newIdNumber = 1; // 没有记录，从 1 开始
                }

                // 生成新 RatingID，格式为 "RT" + 补零后的数字
                $rating->RatingID = 'RT' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
            }
        });
    }
    protected $fillable = [
        'RatingID',
        'PlayerID',
        'GameID',
        'RatingMark',
        'RatingText',
        'RatingImageURL',
        'RatingVideoURL',
        'RatingTime',
        'TotalLikeReceived',
    ];

    // 定义与 Player 模型的关系：一个评分属于一个玩家
    public function player()
    {
        return $this->belongsTo(Player::class, 'PlayerID', 'PlayerID');
    }

    // 定义与 Game 模型的关系：一个评分属于一个游戏
    public function game()
    {
        return $this->belongsTo(Game::class, 'GameID', 'GameID');
    }

    public function likes()
    {
        return $this->hasMany(RatingLike::class, 'RatingID', 'RatingID');
    }



}
