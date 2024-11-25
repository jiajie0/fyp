<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;// 定义了进行身份验证所需的基础方法,便于module使用 Laravel 的身份验证功能

class Staff extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    //通常，Laravel 会将模型类名转换为小写复数形式作为表名。例如，Player 类会默认对应一个名为 players
    //例如，Player 类会默认对应一个名为 players的数据库表，Post 类则对应 posts 表，等等。
    protected $table = 'staff';  // 如果database遵循这种命名规则，可以删除这行

    protected $primaryKey = 'StaffID';
    public $incrementing = false;
    protected $keyType = 'string';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($staff) {
            // 如果没有 StaffID 则生成
            if (!$staff->StaffID) {
                // 查找最后一位 StaffID
                $lastStaff = Staff::orderBy('StaffID', 'desc')->first();

                // 如果有记录，处理 ID
                if ($lastStaff) {
                    $lastIdNumber = (int) substr($lastStaff->StaffID, 2);
                    $newIdNumber = $lastIdNumber + 1;
                } else {
                    $newIdNumber = 1; // 没有记录，从 1 开始
                }

                // 生成新 StaffID，格式为 "SF" + 补零后的数字
                $staff->StaffID = 'SF' . str_pad($newIdNumber, 10, '0', STR_PAD_LEFT);
            }
        });
    }

    protected $fillable = [
        'StaffID',
        'StaffName',
        'StaffEmail',
        'StaffPW'
    ];

    //one staff can create many event
    public function posts()
    {
        return $this->hasMany(Event::class, 'StaffID', 'StaffID');//没有ondelete就不会关联删除
    }

    public function getAuthIdentifier()
    {
        return $this->StaffID; // 返回主键字段的值
    }
}
