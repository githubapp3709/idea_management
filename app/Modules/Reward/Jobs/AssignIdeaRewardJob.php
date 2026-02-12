<?php

namespace App\Modules\Reward\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Idea;
use App\Modules\Reward\Services\RewardService;

class AssignIdeaRewardJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Idea $idea) {}

    public function handle(RewardService $rewardService)
    {
        $rewardService->assignForIdea($this->idea);
    }
}
