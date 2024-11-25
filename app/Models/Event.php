<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model

{
    //通常，Laravel 会将模型类名转换为小写复数形式作为表名。例如，Player 类会默认对应一个名为 players
    //例如，Player 类会默认对应一个名为 players的数据库表，Post 类则对应 posts 表，等等。
    protected $table = 'events';  // 如果database遵循这种命名规则，可以删除这行

    use HasFactory;

    protected $primaryKey = 'EventID';
    public $incrementing = true;
    protected $keyType = 'string';

    protected static function boot()
{
    parent::boot();

    static::creating(function ($event) {
        // 如果没有 EventID 则生成
        if (!$event->EventID) {
            // 查找最后一位 EventID
            $lastEvent = Event::orderBy('EventID', 'desc')->first();

            // 如果有记录，处理 ID
            if ($lastEvent) {
                $lastIdNumber = (int) substr($lastEvent->EventID, 2);
                $newIdNumber = $lastIdNumber + 1;
            } else {
                $newIdNumber = 1; // 没有记录，从 1 开始
            }

            // 生成新 EventID，格式为 "SF" + 补零后的数字
            $event->EventID = 'SF' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
        }
    });
}

    protected $fillable = [
        'EventID',
        'StaffID',
        'EventName',
        'EventImageURL',
    ];

    // 与 Staff 之间的一对多关系：一个事件由一个 Staff 创建
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'StaffID', 'StaffID');
    }
}
