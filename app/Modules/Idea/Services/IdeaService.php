<?php

namespace App\Modules\Idea\Services;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Modules\Idea\Events\IdeaApproved;
use App\Modules\Idea\Events\IdeaRejected;
use App\Modules\Idea\Repositories\IdeaRepository;
use Illuminate\Support\Facades\Auth;
use App\Modules\Idea\Events\IdeaSubmitted;
use Illuminate\Support\Facades\Log;


class IdeaService
{
    public function __construct(
        protected IdeaRepository $ideaRepo
    ) {}

    public function create(array $data)
    {
        return $this->ideaRepo->create([
            ...$data,
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->team_id,
            'status' => IdeaStatus::Draft,
        ]);
    }

    public function submit(Idea $idea)
    {
        if ($idea->status !== IdeaStatus::Draft) {
            throw new \Exception('Only draft ideas can be submitted');
        }

        $idea->update([
            'status' => IdeaStatus::Submitted,
            'submitted_at' => now(),
        ]);

        \Log::info('IdeaSubmitted event fired', [
            'idea_id' => $idea->id,
        ]);

        event(new IdeaSubmitted($idea));

        return $idea;
    }


    public function review(Idea $idea, string $action, ?string $remark = null)
    {
        if ($idea->status !== IdeaStatus::Submitted) {
            throw new \Exception('Idea is not ready for review');
        }

        match ($action) {
            'approve' => $this->approve($idea, $remark),
            'reject' => $this->reject($idea, $remark),
            'send_back' => $this->sendBack($idea, $remark),
        };

        return $idea;
    }


    protected function approve(Idea $idea, ?string $remark)
    {
        $idea->update([
            'status' => IdeaStatus::Approved,
            'review_remark' => $remark,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        event(new IdeaApproved($idea));
    }


    protected function reject(Idea $idea, ?string $remark)
    {
        $idea->update([
            'status' => IdeaStatus::Rejected,
            'review_remark' => $remark,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        event(new IdeaRejected($idea));
    }


    protected function sendBack(Idea $idea, ?string $remark)
    {
        $idea->update([
            'status' => IdeaStatus::Draft,
            'review_remark' => $remark,
        ]);
    }


    public function update(Idea $idea, array $data): Idea
    {
        // Safety check (business rule)
        if ($idea->status !== IdeaStatus::Draft) {
            throw new \Exception('Only draft ideas can be updated.');
        }

        // Update only allowed fields
        $this->ideaRepo->update($idea, [
            'title'        => $data['title'],
            'description'  => $data['description'],
            'category'     => $data['category'],
            'impact_level' => $data['impact_level'],
        ]);

        return $idea;
    }
    
}
