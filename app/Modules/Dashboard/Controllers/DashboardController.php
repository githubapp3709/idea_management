<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}
 
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role->name === 'super_admin') {
            return view('dashboard.admin', [
                'data' => $this->dashboardService->admin($request)
            ]);
        }
 
        if ($user->role->name === 'team_lead') {

            return view('dashboard.team_lead', [
                'data' => $this->dashboardService->teamLead($user, $request)
            ]);
        }

        return view('dashboard.employee', [
            'data' => $this->dashboardService->employee($user, $request)
        ]);
    }
}
