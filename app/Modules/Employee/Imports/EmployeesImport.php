<?php
namespace App\Modules\Employee\Imports;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class EmployeesImport
{
    protected $employeeRole;

    public function __construct()
    {
        $this->employeeRole = Role::where('name', 'employee')->firstOrFail();
    }

    public function process($file)
    {
        $rows = Excel::toCollection(null, $file)[0];

        $expected = ['employee_code', 'name', 'email', 'password', 'status'];
        $headings = $rows->first()->toArray();

        if ($headings !== $expected) {
            throw new \Exception('Uploaded file does not match template format.');
        }

        $failedRows = [];
        $validRows = [];

        $fileEmployeeCodes = [];
        $fileEmails = [];

        foreach ($rows->skip(1) as $index => $row) {

            $rowNumber = $index + 2; // header offset

            $data = [
                'employee_code' => trim($row[0]),
                'name' => trim($row[1]),
                'email' => trim($row[2]),
                'password' => $row[3],
                'status' => trim($row[4]),
            ];

            $validator = Validator::make($data, [
                'employee_code' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'status' => 'nullable|in:active,inactive',
            ]);

            $errors = [];

            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->all());
            }

            // 🔹 Duplicate inside file (employee_code)
            if (in_array($data['employee_code'], $fileEmployeeCodes)) {
                $errors[] = 'Duplicate employee_code inside file.';
            }

            // 🔹 Duplicate inside file (email)
            if (in_array($data['email'], $fileEmails)) {
                $errors[] = 'Duplicate email inside file.';
            }

            // 🔹 Duplicate in database (employee_code)
            if (User::where('employee_code', $data['employee_code'])->exists()) {
                $errors[] = 'employee_code already exists in database.';
            }

            // 🔹 Duplicate in database (email)
            if (User::where('email', $data['email'])->exists()) {
                $errors[] = 'email already exists in database.';
            }

            if (!empty($errors)) {

                $data['error'] = implode(' | ', $errors);
                $data['row_number'] = $rowNumber;

                $failedRows[] = $data;

            } else {

                $validRows[] = $data;

                $fileEmployeeCodes[] = $data['employee_code'];
                $fileEmails[] = $data['email'];
            }
        }

        // ❌ If any failed rows, do NOT insert anything
        if (!empty($failedRows)) {
            return ['failed' => $failedRows];
        }

        // ✅ Insert only if ALL valid
        DB::transaction(function () use ($validRows) {

            foreach ($validRows as $row) {

                User::create([
                    'employee_code' => $row['employee_code'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make(
                        $row['password'] ?: 'password123'
                    ),
                    'status' => $row['status'] ?? 'active',
                    'role_id' => $this->employeeRole->id,
                ]);
            }
        });

        return ['failed' => []];
    }
}
