<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardLog extends Model
{
    protected $fillable = [
        'user_id',
        'idea_id',
        'points',
        'reason',
    ];
}
