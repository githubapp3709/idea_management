<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;
use Illuminate\Support\Facades\Auth;


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
            return view('dashboard.team_lead', [
                'data' => $this->dashboardService->teamLead($user)
            ]);
        }

        return view('dashboard.employee', [
            'data' => $this->dashboardService->employee($user)
        ]);
    }
}
