<?php

namespace App\Modules\Employee\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::with(['role', 'team'])
            ->get()
            ->map(function ($user) {
                return [
                    $user->employee_code,
                    $user->name,
                    $user->email,
                    $user->role?->name,
                    $user->team?->name,
                    $user->status,
                    $user->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Name',
            'Email',
            'Role',
            'Team',
            'Status',
            'Created At',
        ];
    }
}
