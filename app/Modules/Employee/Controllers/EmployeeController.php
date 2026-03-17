<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Modules\Employee\Services\EmployeeService;
use App\Modules\Employee\Imports\EmployeesImport;
use App\Modules\Employee\Exports\EmployeesExport;
use App\Modules\Employee\Requests\ImportEmployeeRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Employee\Requests\StoreEmployeeRequest;
use App\Modules\Employee\Requests\UpdateEmployeeRequest;


class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService
    ) {}

    public function index(Request $request)
    {
        $employees = $this->employeeService->getEmployees($request);
        $stats = $this->employeeService->getStats();


        
        $roles = Role::all();
        $teams = Team::all();

        return view('employees.index', compact(
            'employees',
            'roles',
            'teams',
            'stats'
        ));
    }

    public function import(ImportEmployeeRequest $request)
    {
        // 🔹 File validation (UI errors)
        $request->validate([
            'file' => 'required|mimes:csv,xlsx|max:2048',
        ]);

        try {

            $import = new EmployeesImport;

            $result = $import->process($request->file('file'));

            if (!empty($result['failed'])) {

                // Generate failed file
                return $this->downloadFailedFile($result['failed']);
            }

            return back()->with('success', 'Employees imported successfully.');
        } catch (\Throwable $e) {

            return back()->withErrors([
                'file' => $e->getMessage()
            ]);
        }
    }


    public function export()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }


    public function bulkDelete(Request $request)
    {
        $this->employeeService->bulkDelete($request->ids ?? []);

        return back()->with('success', 'Selected employees deleted');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="employee_import_template.csv"',
        ];

        $columns = [
            'employee_code',
            'name',
            'email',
            'password',
            'status'
        ];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Sample row
            fputcsv($file, [
                'EMP001',
                'John Doe',
                'john@example.com',
                'password123',
                'active'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    protected function downloadFailedFile($failedRows)
    {
        $filename = 'failed_import_' . now()->timestamp . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($failedRows) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'employee_code',
                'name',
                'email',
                'password',
                'status',
                'error'
            ]);

            foreach ($failedRows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        $teams = Team::all();
        return view('employees.form', compact('teams'));
    }
 
    public function store(StoreEmployeeRequest $request)
    {
        $this->employeeService->create($request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully');
    }

    public function edit(User $user)
    {
        $teams= Team::get();
        return view('employees.form', compact('user','teams'));
    }

    public function update(UpdateEmployeeRequest $request, User $user)
    {
        
        $this->employeeService->update($user, $request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully');
    }

    public function show(User $user)
    {
        // $this->authorize('view', $user); // optional policy

        $user->load(['team', 'role']);
        $ideasCount = $user->ideas()->count();
        // $rewardPoints = $user->rewardLogs()->sum('points');

        return view('employees.show', compact(
            'user',
            'ideasCount',
           
        ));
    }


    public function destroy(User $user)
    {
        $this->employeeService->destroy($user);

        return back()->with('success', 'Employee deleted successfully');
    }
}
