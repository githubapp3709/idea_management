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




class IdeaController extends Controller
{

    public function __construct(
        protected IdeaService $ideaService
    ) {}

    public function index()
    {
        $user = Auth::user();

        $query = Idea::query()->with('user');

        // Draft ideas: only owner should ever see them
        $query->where(function ($q) use ($user) {
            $q->where('status', '!=', IdeaStatus::Draft)
                ->orWhere('user_id', $user->id);
        });

        // Employee → only own ideas
        if ($user->role->name === 'employee') {
            $query->where('user_id', $user->id);
        }

        // Team Lead → team ideas (excluding drafts of others)
        if ($user->role->name === 'team_lead') {
            $query->where('team_id', $user->team_id);
        }

        // Super admin → all non-draft ideas (already handled above)

        $ideas = $query->latest()->paginate(10);

        return view('ideas.index', compact('ideas'));
    }


    public function create()
    {
        return view('ideas.create');
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
        return view('ideas.edit', compact('idea'));
    }


    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        $this->authorize('update', $idea);

        $this->ideaService->update($idea, $request->validated());

        return redirect()
            ->route('ideas.index')
            ->with('success', 'Idea updated successfully');
    }


    public function submit(SubmitIdeaRequest $request, Idea $idea)
    {
        $this->authorize('submit', $idea);
        $this->ideaService->submit($idea);
        return redirect()
            ->route('ideas.index')
            ->with('success', 'Idea submitted for review');
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
        return view('ideas.show', compact('idea'));
    }
}
