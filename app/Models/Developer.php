<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Developer extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    //通常，Laravel 会将模型类名转换为小写复数形式作为表名。例如，Player 类会默认对应一个名为 players
    //例如，Player 类会默认对应一个名为 players的数据库表，Post 类则对应 posts 表，等等。
    protected $table = 'developers';  // 如果database遵循这种命名规则，可以删除这行
    protected $primaryKey = 'DeveloperID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($developer) {
            // 如果没有 DeveloperID 则生成
            if (!$developer->DeveloperID) {
                // 查找最后一位 DeveloperID
                $lastDeveloper = Developer::orderBy('DeveloperID', 'desc')->first();

                // 如果有记录，处理 ID
                if ($lastDeveloper) {
                    $lastIdNumber = (int) substr($lastDeveloper->DeveloperID, 2);
                    $newIdNumber = $lastIdNumber + 1;
                } else {
                    $newIdNumber = 1; // 没有记录，从 1 开始
                }

                // 生成新 DeveloperID，格式为 "DP" + 补零后的数字
                $developer->DeveloperID = 'DP' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
            }
        });
    }

    protected $fillable = [
        'DeveloperID',
        'DeveloperName',
        'DeveloperEmail',
        'CompanyName',
        'DeveloperPW',
    ];

    // 开发者与游戏之间的关系：一个开发者可以开发多个游戏
    public function games()
    {
        return $this->hasMany(Game::class, 'DeveloperID', 'DeveloperID');
    }

    public function getAuthPassword()
    {
        return $this->DeveloperPW;
    }

    public function getAuthIdentifier()
    {
        return $this->DeveloperID; // 返回主键字段的值
    }


}
