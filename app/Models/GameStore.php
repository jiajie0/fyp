<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStore extends Model
{
    protected $table = 'game_store';  // 如果database遵循这种命名规则，可以删除这行

    // 指定复合主键（PlayerID 和 GameID）
    protected $primaryKey = ['PlayerID', 'GameID']; //可能出问题！！！！！！！！
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = true;
    use HasFactory;

    // 指定主键（在这种情况下，GameStore 使用复合主键）
    // Laravel 默认支持单一主键，复合主键不支持自动处理，后续操作中需要自行管理
    // 因此不需要设置 `$primaryKey` 和 `$incrementing`

    protected $fillable = [
        'PlayerID',
        'GameID',
        'GameAchievementsCount',
        'PlayerAchievementsCount',
        'TotalPlayTime'
    ];

    // 关联到 Player 模型：每个 GameStore 记录属于一个 Player
    public function player()
    {
        return $this->belongsTo(Player::class, 'PlayerID', 'PlayerID');
    }

    // 关联到 Game 模型：每个 GameStore 记录属于一个 Game
    public function game()
    {
        return $this->belongsTo(Game::class, 'GameID', 'GameID');
    }

    //Laravel 无法直接处理复合主键，你需要覆盖模型的方法来手动管理保存和更新逻辑。
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('PlayerID', $this->getAttribute('PlayerID'))
            ->where('GameID', $this->getAttribute('GameID'));
    }

}
