<?php

namespace App\Modules\Team\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Team\Services\TeamService;
use App\Modules\Team\Requests\StoreTeamRequest;
use App\Modules\Team\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{
    public function __construct(
        protected TeamService $teamService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Team List
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->authorize('viewAny', Team::class);
        $teams = Team::with(['leader', 'members'])->paginate(10);

        return view('teams.index', compact('teams'));
    }
    /*
    |--------------------------------------------------------------------------
    | Create Form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $employees = User::whereHas('role', function ($q) {
            $q->where('name', 'employee');
        })
            ->whereNull('team_id') // only unassigned employees
            ->get(['id', 'name']);

        return view('teams.create', compact('employees'));
    }
    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(StoreTeamRequest $request)
    {
        $this->authorize('create', Team::class);

        $this->teamService->saveTeamWithMembers(
            null,
            $request->validated(),
            $request->members ?? []
        );

        return redirect()
            ->route('teams.index')
            ->with('success', 'Team created successfully');
    }
    /*
    |--------------------------------------------------------------------------
    | Edit Form
    |--------------------------------------------------------------------------
    */
    public function edit(Team $team)
    {
        $this->authorize('update', $team);

        $allEmployees = User::whereHas('role', function ($q) {
            $q->where('name', 'employee')
                ->orWhere('name', 'team_lead');
        })->get(['id', 'name', 'team_id']);

        $selectedMembers = $allEmployees
            ->where('team_id', $team->id)
            ->values();

        $availableEmployees = $allEmployees
            ->whereNull('team_id')
            ->values();

        return view('teams.edit', [
            'team' => $team,
            'availableEmployees' => $availableEmployees,
            'selectedMembers' => $selectedMembers,
        ]);
    }
    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->authorize('update', $team);

        $this->teamService->saveTeamWithMembers(
            $team,
            $request->validated(),
            $request->members ?? []
        );

        return redirect()
            ->route('teams.index')
            ->with('success', 'Team updated successfully');
    }
    /*
    |--------------------------------------------------------------------------
    | Show Assign Members Page
    |--------------------------------------------------------------------------
    */
    public function members(Team $team)
    {
        $this->authorize('update', $team);
        $employees = User::whereHas('role', function ($q) {
            $q->where('name', 'employee');
        })->get();

        return view('teams.members', compact('team', 'employees'));
    }
    /*
    |--------------------------------------------------------------------------
    | Update Members
    |--------------------------------------------------------------------------
    */    
    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);

        $this->teamService->delete($team);

        return redirect()
            ->route('teams.index')
            ->with('success', 'Team deleted successfully');
    }
}
