<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Idea;

use App\Models\User;
use App\Models\Team;
use App\Modules\Employee\Policies\EmployeesPolicy;
use App\Modules\Idea\Policies\IdeaPolicy;
use App\Modules\Team\Policies\TeamPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Gate::policy(Idea::class, IdeaPolicy::class);
        Gate::policy(Team::class, TeamPolicy::class);
        Gate::policy(User::class, EmployeesPolicy::class);
    }
}
