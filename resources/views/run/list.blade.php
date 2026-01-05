<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tanseeq Run - Registrations List (Admin)</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #f5f5f5;
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
        }
        .container {
            max-width: 100%;
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .action-buttons {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .btn {
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-size: 14px;
            min-height: 44px;
            text-align: center;
            flex: 1 1 auto;
            min-width: 120px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-edit {
            background-color: #ffc107;
            color: #000;
            padding: 5px 10px;
            font-size: 12px;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            min-width: 800px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            white-space: nowrap;
        }
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .count {
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .attendance-section {
            margin-bottom: 15px;
        }
        @media (max-width: 576px) {
            body {
                padding: 5px;
                font-size: 14px;
            }
            .container {
                padding: 10px;
            }
            h2 {
                font-size: 18px;
                margin-bottom: 12px;
            }
            .attendance-section {
                padding: 10px !important;
            }
            .attendance-section h3 {
                font-size: 16px !important;
            }
            .action-buttons {
                flex-direction: column;
                gap: 8px;
            }
            .btn {
                width: 100%;
                padding: 12px;
                font-size: 15px;
            }
            .count {
                font-size: 14px;
            }
            table {
                font-size: 11px;
            }
            th, td {
                padding: 6px 4px;
            }
            .btn-edit {
                padding: 6px 12px;
                font-size: 12px;
            }
            #attendance_result > div {
                flex-direction: column !important;
            }
            #attendance_result button {
                width: 100%;
                margin-top: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tanseeq Run - All Registrations (Admin)</h2>
        
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        
        <div class="count">Total Registrations: {{ $registrations->count() }}</div>
        
        <!-- Attendance Marking Section -->
        <div class="attendance-section" style="background: #fff; padding: 15px; border-radius: 5px; margin-bottom: 15px; border: 2px solid #007bff;">
            <h3 style="margin-top: 0; margin-bottom: 15px; color: #007bff; font-size: 18px;">📋 Mark Attendance</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="attendance_employee_id" style="display: block; margin-bottom: 5px; font-weight: 500;">Search Employee ID:</label>
                    <input type="text" id="attendance_employee_id" class="form-control" 
                           placeholder="Enter Employee ID" style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <button onclick="searchEmployeeForAttendance()" class="btn btn-primary" style="min-width: 120px;">Search</button>
            </div>
            
            <!-- Search Results -->
            <div id="attendance_result" style="margin-top: 15px; display: none;">
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <strong id="result_name"></strong><br>
                            <small style="color: #666;">ID: <span id="result_employee_id"></span> | 
                            Category: <span id="result_category"></span> | 
                            Bib: <span id="result_bib"></span></small>
                        </div>
                        <div>
                            <button onclick="markAttendance('present')" class="btn btn-success" style="min-width: 120px;">✓ Mark Present</button>
                        </div>
                    </div>
                    <div id="attendance_status_display" style="margin-top: 10px; font-weight: bold;"></div>
                </div>
            </div>
            
            <div id="attendance_error" style="margin-top: 10px; display: none; padding: 10px; background: #f8d7da; color: #721c24; border-radius: 4px;"></div>
        </div>
        
        <div class="action-buttons">
            <a href="/tanseeq-run" class="btn btn-primary">Create New Registration</a>
            <a href="/tanseeq-run/export" class="btn btn-success">Download All CSV</a>
            <a href="/tanseeq-run/export-presentees" class="btn" style="background-color: #28a745; color: white;">Download Presentees Only</a>
            @if(isset($isSuperAdmin) && $isSuperAdmin)
                <a href="{{ route('admin.register') }}" class="btn" style="background-color: #6c757d; color: white;">Create Admin Account</a>
            @endif
            <a href="{{ route('admin.logout') }}" class="btn" style="background-color: #dc3545; color: white;">Logout</a>
        </div>
       
        <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Registration ID</th>
                    <th>Bib Number</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Company</th>
                    <th>Contact Number</th>
                    <th>RUN Category</th>
                    <th>T-Shirt Size</th>
                    <th>Attendance</th>
                    <th>Registered At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->registration_id ?? 'N/A' }}</td>
                    <td>{{ $r->bib_number ?? '-' }}</td>
                    <td>{{ $r->employee_id }}</td>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->designation }}</td>
                    <td>{{ $r->company }}</td>
                    <td>{{ $r->contact_number }}</td>
                    <td>{{ $r->run_category }}</td>
                    <td>{{ $r->tshirt_size }}</td>
                    <td>
                        @if($r->attendance_status === 'present')
                            <span style="color: #28a745; font-weight: bold;">✓ Present</span>
                        @else
                            <span style="color: #6c757d;">Pending</span>
                        @endif
                    </td>
                    <td>{{ $r->created_at ? $r->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('registrations.edit', $r->id) }}" class="btn btn-edit">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" style="text-align: center; padding: 20px; color: #999;">
                        No registrations found yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <script>
        let currentRegistrationId = null;

        function searchEmployeeForAttendance() {
            const employeeId = document.getElementById('attendance_employee_id').value.trim();
            const resultDiv = document.getElementById('attendance_result');
            const errorDiv = document.getElementById('attendance_error');
            
            if (!employeeId) {
                errorDiv.textContent = 'Please enter an Employee ID';
                errorDiv.style.display = 'block';
                resultDiv.style.display = 'none';
                return;
            }
            
            errorDiv.style.display = 'none';
            resultDiv.style.display = 'none';
            
            fetch('{{ route("attendance.search") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ employee_id: employeeId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    errorDiv.textContent = data.error;
                    errorDiv.style.display = 'block';
                    resultDiv.style.display = 'none';
                } else {
                    currentRegistrationId = data.id;
                    document.getElementById('result_name').textContent = data.name;
                    document.getElementById('result_employee_id').textContent = data.employee_id;
                    document.getElementById('result_category').textContent = data.run_category;
                    document.getElementById('result_bib').textContent = data.bib_number || 'N/A';
                    
                    updateAttendanceStatusDisplay(data.attendance_status);
                    resultDiv.style.display = 'block';
                    errorDiv.style.display = 'none';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'Error searching employee. Please try again.';
                errorDiv.style.display = 'block';
                resultDiv.style.display = 'none';
            });
        }

        function markAttendance(status) {
            if (!currentRegistrationId) {
                alert('Please search for an employee first');
                return;
            }
            
            fetch('{{ route("attendance.mark") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    registration_id: currentRegistrationId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateAttendanceStatusDisplay(data.attendance_status);
                    // Reload page after 1 second to show updated status in table
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert('Error marking attendance. Please try again.');
                }
            })
            .catch(error => {
                alert('Error marking attendance. Please try again.');
            });
        }

        function updateAttendanceStatusDisplay(status) {
            const statusDiv = document.getElementById('attendance_status_display');
            if (status === 'present') {
                statusDiv.innerHTML = '<span style="color: #28a745;">✓ Status: Present</span>';
            } else {
                statusDiv.innerHTML = '<span style="color: #6c757d;">Status: Pending</span>';
            }
        }

        // Allow Enter key to search
        document.getElementById('attendance_employee_id').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchEmployeeForAttendance();
            }
        });
    </script>
</body>
</html>
