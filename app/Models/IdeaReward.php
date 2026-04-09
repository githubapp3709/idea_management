<?php

namespace App\Models;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Model;

class IdeaReward extends Model
{
    protected $fillable = [
        'idea_id',
        'points',
        'bonus_points',
        'awarded_by',
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}
