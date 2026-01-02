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

    public function checkDatabase()
    {
        try {
            $employeeCount = Employee::count();
            $sampleEmployees = Employee::take(5)->get(['employee_id', 'name']);
            
            return response()->json([
                'status' => 'ok',
                'total_employees' => $employeeCount,
                'sample_employee_ids' => $sampleEmployees->pluck('employee_id')->toArray(),
                'message' => $employeeCount > 0 
                    ? "Database has {$employeeCount} employees. Employee lookup should work." 
                    : "⚠️ WARNING: No employees found in database! You need to import the Excel file."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getEmployee(Request $request)
    {
        $employeeId = trim($request->input('employee_id'));
        
        if (empty($employeeId)) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }
        
        try {
            // Try multiple search methods to handle different formats
            $employee = null;
            
            // Method 1: Exact match (case sensitive)
            $employee = Employee::where('employee_id', $employeeId)->first();
            
            // Method 2: Case insensitive with trimmed values
            if (!$employee) {
                $employee = Employee::whereRaw('LOWER(TRIM(employee_id)) = ?', [strtolower(trim($employeeId))])->first();
            }
            
            // Method 3: Try with just trimmed (in case of extra spaces)
            if (!$employee) {
                $employee = Employee::whereRaw('TRIM(employee_id) = ?', [trim($employeeId)])->first();
            }
            
            // Method 4: Try case insensitive without trim (fallback)
            if (!$employee) {
                $employee = Employee::whereRaw('LOWER(employee_id) = ?', [strtolower($employeeId)])->first();
            }
            
            if ($employee) {
                // Check if already registered - use the actual employee_id from database
                $actualEmployeeId = $employee->employee_id;
                $existing = RunRegistration::where('employee_id', $actualEmployeeId)->first();
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
                    ?? '';
                
                return response()->json([
                    'name' => $employee->name ?? '',
                    'designation' => $employee->designation ?? '',
                    'department_projects' => $departmentProjects,
                    'entity' => $employee->entity ?? '',
                ]);
            }
            
            // Check if database has any employees at all
            $totalEmployees = Employee::count();
            
            // Log for debugging
            \Log::info('Employee not found', [
                'employee_id' => $employeeId,
                'total_employees' => $totalEmployees,
                'searched_id' => $employeeId
            ]);
            
            // Provide helpful error message
            $errorMessage = 'Employee not found. Please check your Employee ID and try again.';
            if ($totalEmployees === 0) {
                $errorMessage .= ' (Note: No employees found in database. Please contact administrator to import employee data.)';
            } else {
                $errorMessage .= ' You can also manually enter your details below.';
            }
            
            return response()->json([
                'error' => $errorMessage
            ], 404);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching employee', [
                'employee_id' => $employeeId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'error' => 'Error fetching employee data. Please try again or enter your details manually.'
            ], 500);
        }
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
        // Format: S3-XXXX where XXXX starts from category-specific number
        $startNumber = 0;
        switch ($request->run_category) {
            case '2.5KM':
                $startNumber = 2501; // Starts from S3-2501
                break;
            case '5KM':
                $startNumber = 5001; // Starts from S3-5001
                break;
            case '10KM':
                $startNumber = 10001; // Starts from S3-10001
                break;
            default:
                $startNumber = 1;
        }
        
        // Find the highest existing registration ID for this category
        $existingRegistrations = RunRegistration::where('run_category', $request->run_category)
            ->where('registration_id', 'like', 'S3-%')
            ->get();
        
        $maxNumber = $startNumber - 1; // Start from the base number
        
        foreach ($existingRegistrations as $reg) {
            // Extract number from registration_id (e.g., "S3-2501" -> 2501)
            if (preg_match('/S3-(\d+)/', $reg->registration_id, $matches)) {
                $regNumber = (int)$matches[1];
                if ($regNumber >= $startNumber && $regNumber > $maxNumber) {
                    $maxNumber = $regNumber;
                }
            }
        }
        
        // Generate next sequential number
        $nextNumber = $maxNumber + 1;
        $registrationId = 'S3-' . $nextNumber;
        
        // Double-check it doesn't exist (safety check)
        while (RunRegistration::where('registration_id', $registrationId)->exists()) {
            $nextNumber++;
            $registrationId = 'S3-' . $nextNumber;
        }

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

    public function showRegister()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
        ]);

        // Auto-login after registration
        session(['admin_logged_in' => true]);
        session(['admin_user_id' => $user->id]);

        return redirect()->route('registrations.list')->with('success', 'Account created successfully! You are now logged in.');
    }

    public function login(Request $request)
    {
        // Try user login first
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session(['admin_logged_in' => true]);
            session(['admin_user_id' => \Auth::id()]);
            return redirect()->route('registrations.list')->with('success', 'Login successful!');
        }

        // Fallback to password-based login (for backward compatibility)
        $password = $request->input('password');
        $adminPassword = env('ADMIN_PASSWORD', 'admin123');

        if ($password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('registrations.list')->with('success', 'Login successful!');
        }

        return redirect()->back()->with('error', 'Invalid email or password');
    }

    public function logout(Request $request)
    {
        \Auth::logout();
        session()->forget('admin_logged_in');
        session()->forget('admin_user_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
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

