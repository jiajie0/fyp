<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //通常，Laravel 会将模型类名转换为小写复数形式作为表名。例如，Player 类会默认对应一个名为 players
    //例如，Player 类会默认对应一个名为 players的数据库表，Post 类则对应 posts 表，等等。
    protected $table = 'posts';  // 如果database遵循这种命名规则，可以删除这行
    protected $primaryKey = 'PostID';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasFactory;
    public $timestamps = true; //Laravel 中，$timestamps 默认是 trues可以不用放

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            // 如果没有 PostID 则生成
            if (!$post->PostID) {
                // 查找最后一位 PostID
                $lastPost = Post::orderBy('PostID', 'desc')->first();

                // 如果有记录，处理 ID
                if ($lastPost) {
                    $lastIdNumber = (int) substr($lastPost->PostID, 2);
                    $newIdNumber = $lastIdNumber + 1;
                } else {
                    $newIdNumber = 1; // 没有记录，从 1 开始
                }

                // 生成新 PostID，格式为 "PO" + 补零后的数字
                $post->PostID = 'PO' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
            }
        });
    }


    protected $fillable = [
        'PostID',
        'PlayerID',
        'GameID',
        'PostText',
        'PostImageURL',
        'PostVideoURL',
        'PostTime',
        'TotalLikeReceived'
    ];

    // 定义与 Player 模型的关系：一个玩家可以有多篇帖子
    public function player()
    {
        return $this->belongsTo(Player::class, 'PlayerID', 'PlayerID');
    }

    // 定义与 Game 模型的关系：一个Game可以有多篇帖子
    public function game()
    {
        return $this->belongsTo(Game::class, 'GameID', 'GameID');
    }
}
