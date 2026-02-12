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
        $this->authorize('create', Team::class);
        $users = User::whereHas('role', function ($q) {
            $q->where('name', 'employee');
        })->get();

        return view('teams.create', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(StoreTeamRequest $request)
    {

        $team = $this->teamService->create($request->validated());

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
        $users = User::whereHas('role', function ($q) {
            $q->where('name', 'employee');
        })->get();

        return view('teams.edit', compact('team', 'users'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->authorize('update', $team);
        $team = $this->teamService->update($team, $request->validated());

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
    public function updateMembers(Request $request, Team $team)
    {

        $this->teamService->assignMembers(
            $team,
            $request->members ?? []
        );

        return redirect()
            ->route('teams.index')
            ->with('success', 'Team members updated successfully');
    }

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);

        $this->teamService->delete($team);

        return redirect()
            ->route('teams.index')
            ->with('success', 'Team deleted successfully');
    }
}
