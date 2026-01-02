<!DOCTYPE html>
<html>
<head>
    <title>Tanseeq Run - Registrations List (Admin)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 100%;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .action-buttons {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-right: 10px;
            border: none;
            cursor: pointer;
            font-size: 14px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
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
        
        <div class="action-buttons">
            <a href="/tanseeq-run" class="btn btn-primary">Create New Registration</a>
            <a href="/tanseeq-run/export" class="btn btn-success">Download as CSV</a>
            @if(isset($isSuperAdmin) && $isSuperAdmin)
                <a href="{{ route('admin.register') }}" class="btn" style="background-color: #6c757d; color: white;">Create Admin Account</a>
            @endif
            <a href="{{ route('admin.logout') }}" class="btn" style="background-color: #dc3545; color: white;">Logout</a>
        </div>
       
        
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
                    <th>UN Category</th>
                    <th>T-Shirt Size</th>
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
                    <td>{{ $r->created_at ? $r->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('registrations.edit', $r->id) }}" class="btn btn-edit">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="14" style="text-align: center; padding: 20px; color: #999;">
                        No registrations found yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
