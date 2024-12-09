<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingLike extends Model
{
    use HasFactory;

    protected $table = 'rating_likes';

    protected $fillable = [
        'PlayerID',
        'RatingID',
    ];
}
