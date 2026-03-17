<?php

use App\Http\Controllers\ProfileController;
use App\Modules\Dashboard\Controllers\DashboardController;
use App\Modules\Employee\Controllers\EmployeeController;
use App\Modules\Idea\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;
use App\Modules\Notification\Controllers\NotificationController;
use App\Modules\Team\Controllers\TeamController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //  ---------------Dashboard----------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //  ---------------Teams----------------
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    // Route::get('/teams/{team}/members', [TeamController::class, 'members'])->name('teams.members');
    // Route::post('/teams/{team}/members', [TeamController::class, 'updateMembers'])->name('teams.members.update');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');


    //  ---------------Idea----------------
    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
    Route::get('/ideas/{idea}/edit', [IdeaController::class, 'edit'])->name('ideas.edit');
    Route::put('/ideas/{idea}', [IdeaController::class, 'update'])->name('ideas.update');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('ideas.show');
    Route::delete('/ideas/attachments/{attachment}', [IdeaController::class, 'deleteAttachment'])->name('ideas.attachments.delete');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy');

    Route::post('/ideas/{idea}/submit', [IdeaController::class, 'submit'])->name('ideas.submit');
    Route::post('/ideas/{idea}/review', [IdeaController::class, 'review'])->name('ideas.review');

    //  ---------------Notification----------------
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');


    //  ---------------Employee----------------
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employee/create',[EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employee/{user}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employee/{user}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/employee/{user}/view', [EmployeeController::class, 'show'])->name('employee.show');
    Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::get('/employees/export', [EmployeeController::class, 'export'])->name('employees.export');
    Route::delete('/employees/bulk-delete', [EmployeeController::class, 'bulkDelete'])->name('employees.bulkDelete');
    Route::get('/employees/template', [EmployeeController::class, 'downloadTemplate'])->name('employees.template');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    // Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    // Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employee/{user}', [EmployeeController::class, 'destroy'])->name('employee.destroy');


});


Route::get('/phpinfo', function() {
    phpinfo();
});


require __DIR__ . '/auth.php';
