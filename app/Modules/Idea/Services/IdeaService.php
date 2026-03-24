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
use Illuminate\Support\Facades\Storage;


class IdeaService
{
    public function __construct(
        protected IdeaRepository $ideaRepo
    ) {}



    public function create(array $data)
    {
        // Step 1: Create idea using repository
        $idea = $this->ideaRepo->create([
            ...$data,
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->team_id,
            'status' => IdeaStatus::Draft,
        ]);

        // Step 2: Handle attachments
        $this->handleAttachments($idea);

        return $idea;
    }

    private function handleAttachments(Idea $idea): void
    {
        // Handle Images
        if (request()->hasFile('images')) {

            $existingImages = $idea->attachments()
                ->where('file_type', 'image')
                ->count();

            foreach (request()->file('images') as $image) {

                if ($existingImages >= 5) break;

                $path = $image->store('ideas/images', 'public');

                $idea->attachments()->create([
                    'file_path' => $path,
                    'file_type' => 'image',
                ]);

                $existingImages++;
            }
        }

        // Handle Videos
        if (request()->hasFile('videos')) {

            $existingVideos = $idea->attachments()
                ->where('file_type', 'video')
                ->count();

            foreach (request()->file('videos') as $video) {

                if ($existingVideos >= 2) break;

                $path = $video->store('ideas/videos', 'public');

                $idea->attachments()->create([
                    'file_path' => $path,
                    'file_type' => 'video',
                ]);

                $existingVideos++;
            }
        }
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


    public function update(Idea $idea, array $data)
    {
        // Update basic idea fields using repository
        $this->ideaRepo->update($idea, $data);

        // Handle new attachments
        $this->handleAttachments($idea);

        return $idea;
    }

    public function delete(Idea $idea): void
    {
        // Delete attachments files
        foreach ($idea->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        // Delete idea (soft delete recommended)
        $this->ideaRepo->delete($idea);
    }

    public function getIdeas($request, $user)
{
    return $this->ideaRepo->getFilteredIdeas($request, $user);
}

public function getStats($user)
{
    return $this->ideaRepo->getStats($user);
}
}
 