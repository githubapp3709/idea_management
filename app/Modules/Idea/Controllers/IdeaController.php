<?php

namespace App\Modules\Idea\Controllers;

use App\Enums\IdeaStatus;
use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Modules\Idea\Services\IdeaService;
use App\Modules\Idea\Requests\StoreIdeaRequest;
use App\Modules\Idea\Requests\UpdateIdeaRequest;
use App\Modules\Idea\Requests\SubmitIdeaRequest;
use App\Modules\Idea\Requests\ReviewIdeaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\IdeaAttachment;
use Illuminate\Support\Facades\Storage;


class IdeaController extends Controller
{
    public function __construct(
        protected IdeaService $ideaService
    ) {}



    public function index(Request $request)
    {
        $user = auth()->user();

        /*
    |--------------------------------------------------------------------------
    | BASE VISIBILITY QUERY (NO STATUS FILTER)
    |--------------------------------------------------------------------------
    */

        $baseQuery = Idea::query();

        if ($user->role->name === 'employee') {
            $baseQuery->where('user_id', $user->id);
        } elseif ($user->role->name === 'team_lead') {
            $baseQuery->where('team_id', $user->team_id);
        } elseif ($user->role->name === 'super_admin') {
            $baseQuery->where(function ($q) use ($user) {
                $q->where('status', '!=', 'draft')
                    ->orWhere('user_id', $user->id);
            });
        }

        /*
    |--------------------------------------------------------------------------
    | STATS (ALWAYS FROM BASE QUERY)
    |--------------------------------------------------------------------------
    */

        $stats = [
            'total'     => (clone $baseQuery)->count(),
            'draft'     => (clone $baseQuery)->where('status', 'draft')->count(),
            'submitted' => (clone $baseQuery)->where('status', 'submitted')->count(),
            'approved'  => (clone $baseQuery)->where('status', 'approved')->count(),
            'rejected'  => (clone $baseQuery)->where('status', 'rejected')->count(),
        ];

        /*
    |--------------------------------------------------------------------------
    | TABLE QUERY (FILTER APPLIED HERE ONLY)
    |--------------------------------------------------------------------------
    */

        $query = clone $baseQuery;

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ideas = $query->latest()->paginate(10)->withQueryString();

        return view('ideas.index', compact('ideas', 'stats'));
    }


    public function create()
    {
        $previousIdeas = auth()->user()
            ->ideas()
            ->latest()
            ->take(3)
            ->get(['id', 'title', 'status', 'created_at']);

        return view('ideas.create', compact('previousIdeas'));
    }


    public function store(StoreIdeaRequest $request)
    {
        $this->ideaService->create($request->validated());

        return redirect()
            ->route('ideas.index')
            ->with('success', 'Idea saved as draft');
    }


    public function edit(Idea $idea)
    {
        $this->authorize('update', $idea);


        $previousIdeas = auth()->user()
            ->ideas()
            ->latest()
            ->take(3)
            ->get(['id', 'title', 'status', 'created_at']);
        // Only allow editing draft
        if ($idea->status !== IdeaStatus::Draft) {
            abort(403, 'Only draft ideas can be edited.');
        }

        $idea->load('attachments');

        return view('ideas.edit', compact('idea', 'previousIdeas'));
    }



    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        $this->authorize('update', $idea);

        if ($idea->status !== IdeaStatus::Draft) {
            abort(403, 'Only draft ideas can be edited.');
        }

        $this->ideaService->update($idea, $request->validated());

        return redirect()
            ->route('ideas.index')
            ->with('success', 'The idea has been updated successfully');
    }



    public function submit(SubmitIdeaRequest $request, Idea $idea)
    {
        $this->authorize('submit', $idea);
        $this->ideaService->submit($idea);
        return redirect()
            ->route('ideas.index')
            ->with('success', 'Your idea submitted for review');
    }


    public function review(ReviewIdeaRequest $request, Idea $idea)
    {
        $this->authorize('review', $idea);

        $this->ideaService->review(
            $idea,
            $request->action,
            $request->remark
        );

        return redirect()
            ->route('ideas.index')
            ->with('success', 'Idea reviewed successfully');
    }


    public function show(Idea $idea)
    {
        $this->authorize('view', $idea);

        $idea->load('user.team', 'attachments');

        return view('ideas.show', compact('idea'));
    }


    public function deleteAttachment(IdeaAttachment $attachment)
    {
        $idea = $attachment->idea;

        $this->authorize('update', $idea);

        if ($idea->status !== IdeaStatus::Draft) {
            abort(403);
        }

        // Delete file from storage
        Storage::disk('public')->delete($attachment->file_path);

        $attachment->delete();

        return back()->with('success', 'Attachment removed.');
    }

    public function destroy(Idea $idea)
    {
        $this->authorize('delete', $idea);

        if ($idea->status !== \App\Enums\IdeaStatus::Draft) {
            abort(403, 'Only draft ideas can be deleted.');
        }

        $this->ideaService->delete($idea);

        return redirect()
            ->route('ideas.index')
            ->with('success', 'Draft idea deleted successfully.');
    }
}
