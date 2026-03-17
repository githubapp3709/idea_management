<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

use App\Models\Idea;
use App\Models\User;
use App\Models\Team;
use App\Enums\IdeaStatus;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $notifications = auth()->user()->notifications;
        $unreadNotifications = auth()->user()->unreadNotifications;

        $user = Auth::user();

        // return match ($user->role->name) {
        //     'super_admin' => $this->dashboardService->admin(),
        //     'team_lead'   => $this->dashboardService->teamLead($user),
        //     default       => $this->dashboardService->employee($user),
        // };
 
        if ($user->role->name === 'super_admin') {
            return view('dashboard.admin', [
                'data' => $this->dashboardService->admin()
            ]);
        }

        if ($user->role->name === 'team_lead') {
            $range = request('range', '6months');
            return view('dashboard.team_lead', [
                'data' => $this->dashboardService->teamLead($user, $range)
            ]);
        }

        return view('dashboard.employee', [
            'data' => $this->dashboardService->employee($user)
        ]);
    }


    public function admin(): array
    {
        // ================= IDEA STATS =================
        $stats = [
            'total_ideas' => Idea::count(),
            'draft_ideas' => Idea::where('status', IdeaStatus::Draft)->count(),
            'submitted_ideas' => Idea::where('status', IdeaStatus::Submitted)->count(),
            'approved_ideas' => Idea::where('status', IdeaStatus::Approved)->count(),
            'rejected_ideas' => Idea::where('status', IdeaStatus::Rejected)->count(),
            'this_month_ideas' => Idea::whereMonth('created_at', now()->month)->count(),
        ];

        // Approval Rate
        $stats['approval_rate'] = $stats['total_ideas'] > 0
            ? round(($stats['approved_ideas'] / $stats['total_ideas']) * 100)
            : 0;

        // ================= EMPLOYEE STATS =================
        $employeeStats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'assigned' => User::whereNotNull('team_id')->count(),
            'unassigned' => User::whereNull('team_id')->count(),
            'leaders' => User::whereHas(
                'role',
                fn($q) =>
                $q->where('name', 'team_lead')
            )->count(),
        ];

        // ================= RECENT IDEAS =================
        $recentIdeas = Idea::with('user')
            ->latest()
            ->take(5)
            ->get();

        // ================= TOP CONTRIBUTORS =================
        $topContributors = User::orderByDesc('reward_points')
            ->take(5)
            ->get();

        // ================= TOP TEAMS =================
        $topTeams = Team::withSum('ideas as total_points', 'reward_points')
            ->orderByDesc('total_points')
            ->take(5)
            ->get();

        return [
            'stats' => $stats,
            'employee_stats' => $employeeStats,
            'recent_ideas' => $recentIdeas,
            'top_contributors' => $topContributors,
            'top_teams' => $topTeams,
        ];
    }
}

