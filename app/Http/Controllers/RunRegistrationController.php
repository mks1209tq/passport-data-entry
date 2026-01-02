<?php

namespace App\Http\Controllers;

use App\Models\RunRegistration;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RunRegistrationController extends Controller
{
    public function create()
    {
        return view('run.register');
    }

    public function getEmployee(Request $request)
    {
        $employeeId = $request->input('employee_id');
        
        // Try to find employee - works with any table name you specify in Employee model
        $employee = Employee::where('employee_id', $employeeId)->first();
        
        if ($employee) {
            // Check if already registered
            $existing = RunRegistration::where('employee_id', $employeeId)->first();
            if ($existing) {
                return response()->json([
                    'error' => 'This employee ID has already been registered.',
                    'registration_id' => $existing->registration_id
                ], 400);
            }
            
            // Get department/projects - try different possible field names
            $departmentProjects = $employee->department_projects 
                ?? $employee->department 
                ?? $employee->projects 
                ?? $employee->department_projects 
                ?? '';
            
            return response()->json([
                'name' => $employee->name,
                'designation' => $employee->designation,
                'department_projects' => $departmentProjects,
                'entity' => $employee->entity,
            ]);
        }
        
        return response()->json(['error' => 'Employee not found'], 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|unique:run_registrations',
            'name' => 'required',
            'designation' => 'required',
            'company' => 'required',
            'entity' => 'required',
            'dob' => 'required|date',
            'run_category' => 'required|in:2.5KM,5KM,10KM',
            'contact_number' => 'required|digits_between:10,12',
            'tshirt_size' => 'required|in:S,M,L,XL,XXL,XXXL',
        ]);

        // Generate unique registration ID based on run category
        $categoryPrefix = '';
        switch ($request->run_category) {
            case '2.5KM':
                $categoryPrefix = '2.5-';
                break;
            case '5KM':
                $categoryPrefix = '5-';
                break;
            case '10KM':
                $categoryPrefix = '10-';
                break;
            default:
                $categoryPrefix = 'TR-';
        }
        
        do {
            // Generate 5 random digits
            $randomNumbers = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
            $registrationId = $categoryPrefix . $randomNumbers;
        } while (RunRegistration::where('registration_id', $registrationId)->exists());

        $registration = RunRegistration::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'designation' => $request->designation,
            'company' => $request->company,
            'entity' => $request->entity,
            'dob' => $request->dob,
            'run_category' => $request->run_category,
            'contact_number' => $request->contact_number,
            'tshirt_size' => $request->tshirt_size,
            'registration_id' => $registrationId,
            // Bib number will be assigned later by admin
        ]);

        return redirect()->back()->with([
            'success' => 'Registration successful! Your Registration ID is: ' . $registrationId,
            'registration_id' => $registrationId
        ]);
    }

    public function index()
    {
        $registrations = RunRegistration::latest()->get();
        return view('run.list', compact('registrations'));
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $password = $request->input('password');
        $adminPassword = env('ADMIN_PASSWORD', 'admin123'); // Default password, change in .env

        if ($password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('registrations.list')->with('success', 'Login successful!');
        }

        return redirect()->back()->with('error', 'Invalid password');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }

    public function edit($id)
    {
        $registration = RunRegistration::findOrFail($id);
        return view('run.edit', compact('registration'));
    }

    public function update(Request $request, $id)
    {
        $registration = RunRegistration::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'company' => 'required',
            'entity' => 'required',
            'dob' => 'required|date',
            'run_category' => 'required|in:2.5KM,5KM,10KM',
            'contact_number' => 'required|digits_between:10,12',
            'tshirt_size' => 'required|in:S,M,L,XL,XXL,XXXL',
        ]);

        $registration->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'company' => $request->company,
            'entity' => $request->entity,
            'dob' => $request->dob,
            'run_category' => $request->run_category,
            'contact_number' => $request->contact_number,
            'tshirt_size' => $request->tshirt_size,
        ]);

        return redirect()->route('registrations.list')->with('success', 'Registration updated successfully!');
    }

    public function export()
    {
        $registrations = RunRegistration::latest()->get();
        
        $filename = 'tanseeq_run_registrations_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row
            fputcsv($file, [
                'Registration ID',
                'Bib Number',
                'Employee ID',
                'Name',
                'Designation',
                'Department/Projects',
                'Entity',
                'Date of Birth',
                'Contact Number',
                'UN Category',
                'T-Shirt Size',
                'Registered At'
            ]);
            
            // Data rows
            foreach ($registrations as $r) {
                fputcsv($file, [
                    $r->registration_id ?? 'N/A',
                    $r->bib_number ?? '-',
                    $r->employee_id,
                    $r->name,
                    $r->designation,
                    $r->company,
                    $r->entity,
                    $r->dob ? \Carbon\Carbon::parse($r->dob)->format('d/m/Y') : 'N/A',
                    $r->contact_number,
                    $r->run_category,
                    $r->tshirt_size,
                    $r->created_at ? $r->created_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

