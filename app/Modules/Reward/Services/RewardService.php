<?php

namespace App\Modules\Reward\Services;

use App\Models\Idea;
use App\Models\IdeaReward;
use App\Models\RewardLog;
use Illuminate\Support\Facades\DB;

class RewardService
{
    public function assignForIdea(Idea $idea)
    {
        return DB::transaction(function () use ($idea) {

            // Base points (simple for now)
            $points = match ($idea->impact_level) {
                'high' => 100,
                'medium' => 60,
                'low' => 30,
            };

            IdeaReward::create([
                'idea_id' => $idea->id,
                'points' => $points,
                'awarded_by' => auth()->id(),
            ]);

            RewardLog::create([
                'user_id' => $idea->user_id,
                'idea_id' => $idea->id,
                'points' => $points,
                'reason' => 'Idea approved',
            ]);

            // Update user total points
            $idea->user->increment('reward_points', $points);
        });
    }
}
