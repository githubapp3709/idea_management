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
        $user = Auth::user();

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
}