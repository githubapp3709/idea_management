<?php

namespace App\Modules\Idea\Services;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Modules\Idea\Events\IdeaApproved;
use App\Modules\Idea\Events\IdeaRejected;
use App\Modules\Idea\Events\IdeaSentBack;
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

    public function index($request)
    {
        $query = $this->ideaRepo->baseQuery($request); // create baseQuery()

        return [
            'ideas' => $query->paginate(10)->withQueryString(),
            'stats' => $this->ideaRepo->filteredStatsFromQuery($query),
        ];
    }


    public function create(array $data)
    {
        $idea = $this->ideaRepo->create([
            ...$data,
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->team_id,
            'status' => IdeaStatus::Draft,
        ]);

        $this->handleAttachments($idea);

        return $idea;
    }

    private function handleAttachments(Idea $idea): void
    {
        if (!request()->hasFile('attachments')) {
            return;
        }

        // Get existing count
        $existingCount = $idea->attachments()->count();

        // Max allowed
        $max = 5;

        foreach (request()->file('attachments') as $file) {

            // STOP if limit reached
            if ($existingCount >= $max) {
                break;
            }

            $path = $file->store('ideas/attachments', 'public');

            $type = $this->detectFileType($file);

            $idea->attachments()->create([
                'file_path' => $path,
                'file_type' => $type,
            ]);

            $existingCount++;
        }
    }

    private function detectFileType($file): string
    {
        $mime = $file->getMimeType();

        if (str_contains($mime, 'image')) {
            return 'image';
        }

        if (str_contains($mime, 'video')) {
            return 'video';
        }

        return 'document';
    }



    public function submit(Idea $idea)
    {
        if ($idea->status !== IdeaStatus::Draft && $idea->status !== IdeaStatus::Feedback) {
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


    public function review(Idea $idea, string $action, $request = null)
    {
        
        if ($idea->status !== IdeaStatus::Submitted) {
            throw new \Exception('Idea is not ready for review');
        }

        match ($action) {
            'approve' => $this->approve($idea, $request),
            'reject' => $this->reject($idea, $request),
            'send_back' => $this->sendBack($idea, $request),
        };

        return $idea;
    }


    protected function approve(Idea $idea, $request)
    {
        $idea->update([
            'status' => IdeaStatus::Approved,
            'review_remark' => $request->remark,
            'impact_level' => $request->impact_level,
            'category' => $request->category,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        event(new IdeaApproved($idea));
    }


    protected function reject(Idea $idea, $request)
    {
        $idea->update([
            'status' => IdeaStatus::Rejected,
            'review_remark' => $request->remark,
            'impact_level' => $request->impact_level,
            'category' => $request->category,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        event(new IdeaRejected($idea));
    }
 
 
    protected function sendBack(Idea $idea, $request)
    {
      
        $idea->update([
            'status' => IdeaStatus::Feedback,
            'review_remark' => $request->remark,
            'impact_level' => $request->impact_level,
            'category' => $request->category,
        ]);
        event(new IdeaSentBack($idea));
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

    public function approvedIdeas($request)
    {
        return $this->ideaRepo->approvedIdeas($request);
    }
}
