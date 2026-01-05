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
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tanseeq Run - All Registrations (Admin)</h2>
        
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif
        
        @if(isset($isSuperAdmin) && !$isSuperAdmin)
            <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ffeaa7;">
                <strong>ℹ️ Info:</strong> You are logged in as a regular admin. Only super admins can create new admin accounts. 
                To create admin accounts, you need to login with a super admin email (set in SUPER_ADMIN_EMAILS in .env file).
            </div>
        @endif
        
        <div class="count">Total Registrations: {{ $registrations->count() }}</div>
        
        <div class="action-buttons">
            <a href="/tanseeq-run" class="btn btn-primary">Create New Registration</a>
            <a href="/tanseeq-run/export" class="btn btn-success">Download All CSV</a>
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

</body>
</html>
