<?php

namespace App\Http\Controllers;

use App\Models\RunRegistration;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class RunRegistrationController extends Controller
{
    /**
     * Check if registration is closed
     * Registration closes on January 8th, 2026 at 12:00 AM (midnight)
     * This means it works all day on Jan 6th and Jan 7th, closes at start of Jan 8th
     * 
     * @param Carbon|null $testTime Optional test time to simulate different times
     */
    private function isRegistrationClosed($testTime = null)
    {
        // Get deadline from environment or use default (Jan 8, 2026 at 12 AM)
        $deadline = env('REGISTRATION_DEADLINE', null);
        
        // Get local timezone from env or default to Asia/Dubai (Dubai/UAE timezone)
        $localTimezone = env('APP_TIMEZONE', 'Asia/Dubai');
        
        if ($deadline) {
            // Parse deadline assuming it's in local timezone (not UTC)
            $deadlineTime = Carbon::parse($deadline, $localTimezone);
        } else {
            // Default: January 8th, 2026 at 12:00 AM (midnight) in local timezone
            $deadlineTime = Carbon::create(2026, 1, 8, 0, 0, 0, $localTimezone);
        }
        
        $currentTime = $testTime ?? now();
        // Convert current time to local timezone for comparison
        $currentTime = $currentTime->setTimezone($localTimezone);
        
        return $currentTime->gte($deadlineTime);
    }

    /**
     * Quick diagnostic endpoint to check deadline status
     */
    public function checkDeadlineStatus()
    {
        $deadline = env('REGISTRATION_DEADLINE', null);
        $localTimezone = env('APP_TIMEZONE', 'Asia/Dubai');
        $currentTime = now();
        
        if ($deadline) {
            // Parse deadline assuming it's in local timezone
            $deadlineTime = Carbon::parse($deadline, $localTimezone);
        } else {
            $deadlineTime = Carbon::create(2026, 1, 8, 0, 0, 0, $localTimezone);
        }
        
        $currentTime = $currentTime->setTimezone($localTimezone);
        $isClosed = $currentTime->gte($deadlineTime);
        
        return response()->json([
            'current_time' => $currentTime->format('Y-m-d H:i:s'),
            'current_timezone' => $localTimezone,
            'deadline_from_env' => $deadline ?: 'NOT SET (using default)',
            'deadline_time' => $deadlineTime->format('Y-m-d H:i:s'),
            'deadline_timezone' => $deadlineTime->timezone->getName(),
            'is_closed' => $isClosed,
            'status' => $isClosed ? 'CLOSED' : 'OPEN',
            'time_until_deadline' => $currentTime->lt($deadlineTime) 
                ? $currentTime->diffForHumans($deadlineTime, true) 
                : 'Deadline has passed',
            'comparison' => [
                'current_timestamp' => $currentTime->timestamp,
                'deadline_timestamp' => $deadlineTime->timestamp,
                'difference_seconds' => $currentTime->timestamp - $deadlineTime->timestamp,
            ],
        ], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Test endpoint to check registration status at different times
     * Usage: /api/test-deadline?time=2026-01-07 11:50:00
     */
    public function testDeadline(Request $request)
    {
        $testTimeStr = $request->input('time');
        
        // Get deadline
        $deadline = env('REGISTRATION_DEADLINE', null);
        if ($deadline) {
            $deadlineTime = Carbon::parse($deadline);
        } else {
            $deadlineTime = Carbon::create(2026, 1, 8, 0, 0, 0);
        }
        
        // Test times to check
        $testTimes = [];
        
        if ($testTimeStr) {
            // Test with provided time
            $testTimes[] = [
                'label' => 'Provided Time',
                'time' => Carbon::parse($testTimeStr),
            ];
        } else {
            // Default test times
            $testTimes = [
                ['label' => 'Today 11:50 AM', 'time' => Carbon::create(2026, 1, 6, 11, 50, 0)],
                ['label' => 'Tomorrow 11:50 AM', 'time' => Carbon::create(2026, 1, 7, 11, 50, 0)],
                ['label' => 'Tomorrow 11:59 PM', 'time' => Carbon::create(2026, 1, 7, 23, 59, 59)],
                ['label' => 'Jan 8th 12:00 AM', 'time' => Carbon::create(2026, 1, 8, 0, 0, 0)],
                ['label' => 'Jan 8th 12:01 AM', 'time' => Carbon::create(2026, 1, 8, 0, 1, 0)],
            ];
        }
        
        // Add current time
        array_unshift($testTimes, [
            'label' => 'Current Time',
            'time' => now(),
        ]);
        
        $results = [];
        foreach ($testTimes as $test) {
            $isClosed = $this->isRegistrationClosed($test['time']);
            $results[] = [
                'label' => $test['label'],
                'time' => $test['time']->format('Y-m-d H:i:s'),
                'is_closed' => $isClosed,
                'status' => $isClosed ? '❌ CLOSED' : '✅ OPEN',
                'time_until_deadline' => $test['time']->lt($deadlineTime) 
                    ? $test['time']->diffForHumans($deadlineTime, true) . ' until deadline'
                    : 'Deadline passed',
            ];
        }
        
        return response()->json([
            'deadline' => $deadlineTime->format('Y-m-d H:i:s'),
            'deadline_readable' => $deadlineTime->format('F j, Y g:i A'),
            'current_time' => now()->format('Y-m-d H:i:s'),
            'test_results' => $results,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function create()
    {
        // Check if registration is closed
        if ($this->isRegistrationClosed()) {
            return view('run.closed');
        }
        
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

    public function checkAdminStatus()
    {
        $isSuperAdmin = $this->isSuperAdmin();
        $isAdmin = $this->isAdmin();
        $user = Auth::user();
        
        $superAdminEmails = env('SUPER_ADMIN_EMAILS', '');
        $superAdminList = array_map('trim', explode(',', $superAdminEmails));
        $superAdminList = array_filter($superAdminList);
        
        return response()->json([
            'is_authenticated' => Auth::check(),
            'is_admin' => $isAdmin,
            'is_super_admin' => $isSuperAdmin,
            'current_user_email' => $user ? $user->email : null,
            'super_admin_emails_configured' => $superAdminList,
            'can_create_admins' => $isSuperAdmin,
            'message' => $isSuperAdmin 
                ? 'You are a super admin and can create admin accounts' 
                : ($isAdmin 
                    ? 'You are a regular admin and cannot create admin accounts' 
                    : 'You are not logged in')
        ]);
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
                'entity' => $employee->entity ?? '', // Map entity to company field in form
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
        // Check if registration is closed
        if ($this->isRegistrationClosed()) {
            return back()->withErrors(['registration_closed' => 'Registration is now closed. The deadline has passed.'])->withInput();
        }

        $request->validate([
            'employee_id' => 'required|unique:run_registrations',
            'name' => 'required',
            'designation' => 'required',
            'company' => 'required',
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
        $isSuperAdmin = $this->isSuperAdmin();
        return view('run.list', compact('registrations', 'isSuperAdmin'));
    }

    public function showAttendance()
    {
        $presentCount = RunRegistration::where('attendance_status', 'present')->count();
        
        return view('run.attendance', compact('presentCount'));
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Check if current user is a super admin
     * Only the 3 initial super admins (defined in .env) can create other admin accounts
     * Admins created by super admins can access admin area but cannot create more admins
     */
    private function isSuperAdmin()
    {
        // Get super admin emails from .env (comma-separated)
        // These are the 3 initial admins who can create other admins
        $superAdminEmails = env('SUPER_ADMIN_EMAILS', '');
        $superAdminList = array_map('trim', explode(',', $superAdminEmails));
        $superAdminList = array_filter($superAdminList); // Remove empty values
        
        // Check if user is logged in and is one of the 3 super admins
        if (Auth::check()) {
            $userEmail = Auth::user()->email;
            return in_array($userEmail, $superAdminList);
        }
        
        return false;
    }

    /**
     * Check if current user is an admin (any admin - super admin or regular admin)
     * All users in the users table are admins and can access admin area
     */
    private function isAdmin()
    {
        // Any authenticated user is an admin
        // Super admins are a subset of admins who can create more admins
        return Auth::check() || session('admin_logged_in');
    }

    public function showRegister()
    {
        // Only super admins can access registration page
        if (!$this->isSuperAdmin()) {
            return redirect()->route('admin.login')->with('error', 'Access denied. Only super admins can create admin accounts.');
        }
        
        return view('admin.register');
    }

    public function register(Request $request)
    {
        // Only super admins can create admin accounts
        if (!$this->isSuperAdmin()) {
            return redirect()->route('admin.login')->with('error', 'Access denied. Only super admins can create admin accounts.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create new admin account
        // This user will be able to access admin area but cannot create more admins
        // Only the 3 super admins (defined in .env) can create admin accounts
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('registrations.list')->with('success', 'Admin account created successfully! The new admin can now login and access the admin area.');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Email is now required for proper authentication
        if (!$email) {
            return redirect()->back()->with('error', 'Email address is required. Please enter your email to login.');
        }

        // Validate email and password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Try to authenticate with email and password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session(['admin_logged_in' => true]);
            session(['admin_user_id' => Auth::id()]);
            return redirect()->route('registrations.list')->with('success', 'Login successful!');
        }

        // If authentication fails, provide helpful error message
        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password. Please check your credentials and try again.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
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
            'run_category' => 'required|in:2.5KM,5KM,10KM',
            'contact_number' => 'required|digits_between:10,12',
            'tshirt_size' => 'required|in:S,M,L,XL,XXL,XXXL',
        ]);

        $registration->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'company' => $request->company,
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
                'Company',
                'Contact Number',
                'RUN Category',
                'T-Shirt Size',
                'Attendance Status',
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
                    $r->contact_number,
                    $r->run_category,
                    $r->tshirt_size,
                    $r->attendance_status ?? 'pending',
                    $r->created_at ? $r->created_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function searchEmployee(Request $request)
    {
        $employeeId = trim($request->input('employee_id'));
        
        if (empty($employeeId)) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }
        
        $registration = RunRegistration::where('employee_id', $employeeId)
            ->orWhere('employee_id', 'LIKE', '%' . $employeeId . '%')
            ->first();
        
        if (!$registration) {
            return response()->json(['error' => 'Employee not found in registrations'], 404);
        }
        
        return response()->json([
            'id' => $registration->id,
            'employee_id' => $registration->employee_id,
            'name' => $registration->name,
            'designation' => $registration->designation,
            'company' => $registration->company,
            'contact_number' => $registration->contact_number,
            'run_category' => $registration->run_category,
            'bib_number' => $registration->bib_number,
            'registration_id' => $registration->registration_id,
            'tshirt_size' => $registration->tshirt_size,
            'attendance_status' => $registration->attendance_status ?? 'pending',
        ]);
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:run_registrations,id',
            'status' => 'required|in:present,pending',
        ]);
        
        $registration = RunRegistration::findOrFail($request->registration_id);
        $registration->attendance_status = $request->status;
        $registration->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully',
            'attendance_status' => $registration->attendance_status,
        ]);
    }

    public function exportPresentees()
    {
        $registrations = RunRegistration::where('attendance_status', 'present')
            ->latest()
            ->get();
        
        $filename = 'tanseeq_run_presentees_' . date('Y-m-d_His') . '.csv';
        
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
                'Company',
                'Contact Number',
                'RUN Category',
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

    public function exportAttendance()
    {
        // Export ONLY present registrations
        $registrations = RunRegistration::where('attendance_status', 'present')
            ->latest()
            ->get();
        
        $filename = 'tanseeq_run_presentees_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row - Attendance Sheet with attendance status
            fputcsv($file, [
                'Registration ID',
                'Bib Number',
                'Employee ID',
                'Name',
                'Designation',
                'Company',
                'Contact Number',
                'RUN Category',
                'T-Shirt Size',
                'Attendance Status',
                'Registered At'
            ]);
            
            // Data rows
            foreach ($registrations as $r) {
                $attendanceStatus = $r->attendance_status ?? 'Pending';
                if ($attendanceStatus === 'present') {
                    $attendanceStatus = 'Present';
                } else {
                    $attendanceStatus = 'Pending';
                }
                
                fputcsv($file, [
                    $r->registration_id ?? 'N/A',
                    $r->bib_number ?? '-',
                    $r->employee_id,
                    $r->name,
                    $r->designation,
                    $r->company,
                    $r->contact_number,
                    $r->run_category,
                    $r->tshirt_size,
                    $attendanceStatus,
                    $r->created_at ? $r->created_at->format('d/m/Y H:i') : 'N/A'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function resetAttendance()
    {
        // Reset all attendance_status to 'pending'
        $updated = RunRegistration::query()->update(['attendance_status' => 'pending']);
        
        return redirect()->route('attendance.show')
            ->with('success', "Successfully reset attendance for {$updated} registration(s). All attendance statuses have been set to 'pending'.");
    }
}

