<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mark Attendance - Tanseeq Run (Admin)</title>
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
            justify-content: flex-end;
        }
        .btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-size: 12px;
            min-height: 32px;
            text-align: center;
            white-space: nowrap;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .attendance-section {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 2px solid #007bff;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
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
            }
            .btn {
                font-size: 11px;
                padding: 5px 10px;
                min-height: 30px;
            }
            .attendance-section {
                padding: 15px;
            }
            .form-control {
                padding: 10px;
                font-size: 16px;
            }
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Mark Attendance - Tanseeq Run</h2>
        
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif
        
        <div class="action-buttons">
            <a href="{{ route('registrations.list') }}" class="btn btn-primary">← Back</a>
            <a href="{{ route('attendance.export') }}" class="btn btn-success">📥 Download</a>
        </div>
        
        <!-- Attendance Marking Section -->
        <div class="attendance-section">
            <h3 style="margin-top: 0; margin-bottom: 15px; color: #007bff; font-size: 18px;">🔍 Search Employee by ID</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 1; min-width: 200px;">
                
                    <input type="text" id="attendance_employee_id" class="form-control" 
                           placeholder="Enter Employee ID" autofocus>
                </div>
                <button onclick="searchEmployeeForAttendance()" class="btn btn-primary" style="min-width: 120px;">Search</button>
            </div>
            
            <!-- Search Results -->
            <div id="attendance_result" style="margin-top: 15px; display: none;">
                <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; border-left: 4px solid #28a745;">
                    <h4 style="margin-top: 0; margin-bottom: 15px; color: #333;">Employee Details</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
                        <div>
                            <strong style="color: #666; font-size: 12px;">Employee ID:</strong><br>
                            <span id="result_employee_id" style="font-size: 16px; font-weight: bold;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">Name:</strong><br>
                            <span id="result_name" style="font-size: 16px; font-weight: bold;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">Designation:</strong><br>
                            <span id="result_designation" style="font-size: 14px;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">Company:</strong><br>
                            <span id="result_company" style="font-size: 14px;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">Contact Number:</strong><br>
                            <span id="result_contact" style="font-size: 14px;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">Run Category:</strong><br>
                            <span id="result_category" style="font-size: 14px; font-weight: bold; color: #007bff;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">Registration ID:</strong><br>
                            <span id="result_registration_id" style="font-size: 14px;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">Bib Number:</strong><br>
                            <span id="result_bib" style="font-size: 14px; font-weight: bold;"></span>
                        </div>
                        <div>
                            <strong style="color: #666; font-size: 12px;">T-Shirt Size:</strong><br>
                            <span id="result_tshirt" style="font-size: 14px;"></span>
                        </div>
                    </div>
                    <div style="border-top: 1px solid #ddd; padding-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div id="attendance_status_display" style="font-weight: bold; font-size: 16px;"></div>
                        <div id="mark_attendance_button_container">
                            <button onclick="markAttendance('present')" class="btn btn-success" style="min-width: 150px; font-size: 16px; padding: 12px;">✓ Mark Present</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="attendance_error" style="margin-top: 10px; display: none; padding: 10px; background: #f8d7da; color: #721c24; border-radius: 4px;"></div>
        </div>
        
        <!-- Statistics -->
        <div style="background: #e9ecef; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 16px;"> total Attendees</h3>
            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div>
                    <strong style="color: #28a745;">Present:</strong> 
                    <span id="present_count">{{ $presentCount ?? 0 }}</span>
                </div>
            </div>
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
            
            // Reset button visibility when starting a new search
            const buttonContainer = document.getElementById('mark_attendance_button_container');
            if (buttonContainer) {
                buttonContainer.style.display = 'block';
            }
            
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
                    document.getElementById('result_employee_id').textContent = data.employee_id;
                    document.getElementById('result_name').textContent = data.name;
                    document.getElementById('result_designation').textContent = data.designation || 'N/A';
                    document.getElementById('result_company').textContent = data.company || 'N/A';
                    document.getElementById('result_contact').textContent = data.contact_number || 'N/A';
                    document.getElementById('result_category').textContent = data.run_category;
                    document.getElementById('result_registration_id').textContent = data.registration_id || 'N/A';
                    document.getElementById('result_bib').textContent = data.bib_number || 'N/A';
                    document.getElementById('result_tshirt').textContent = data.tshirt_size || 'N/A';
                    
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
                    // Show success message
                    const successMsg = document.createElement('div');
                    successMsg.className = 'success-message';
                    successMsg.textContent = '✓ Attendance marked successfully!';
                    document.querySelector('.container').insertBefore(successMsg, document.querySelector('.attendance-section'));
                    
                    // Clear search and reload stats after 1 second
                    setTimeout(() => {
                        document.getElementById('attendance_employee_id').value = '';
                        document.getElementById('attendance_result').style.display = 'none';
                        window.location.reload();
                    }, 1500);
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
            const buttonContainer = document.getElementById('mark_attendance_button_container');
            
            if (status === 'present') {
                statusDiv.innerHTML = '<span style="color: #28a745;">✓ Status: Present</span>';
                // Hide the button if already marked as present
                if (buttonContainer) {
                    buttonContainer.style.display = 'none';
                }
            } else {
                statusDiv.innerHTML = '<span style="color: #6c757d;">Status: Pending</span>';
                // Show the button if not yet marked as present
                if (buttonContainer) {
                    buttonContainer.style.display = 'block';
                }
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

