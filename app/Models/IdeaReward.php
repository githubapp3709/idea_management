<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaReward extends Model
{
   protected $fillable = [
        'idea_id',
        'points',
        'bonus_points',
        'awarded_by',
    ];
}
