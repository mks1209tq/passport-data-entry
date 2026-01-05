<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tanseeq Run Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 10px 0;
        }
        .form-control:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.7;
        }
        .form-control, .form-select {
            font-size: 16px;
            padding: 12px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }
        .form-label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        .text-danger {
            color: #dc3545 !important;
            font-weight: bold;
        }
        .notes-section {
            font-size: 11px;
            color: #666;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .notes-section ol {
            margin-bottom: 0;
            padding-left: 20px;
        }
        .notes-section li {
            margin-bottom: 5px;
        }
        .success-container {
            text-align: center;
            padding: 40px 20px;
        }
        .success-icon {
            font-size: 64px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .registration-id-box {
            background-color: #d4edda;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            display: inline-block;
        }
        .registration-id-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .registration-id-value {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            letter-spacing: 2px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            background: white;
        }
        .card-title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .running-icon {
            font-size: 24px;
        }
        .date-title {
            display: block;
            text-align: center;
            color: #666;
            font-size: 18px;
            margin-bottom: 8px;
        }
        .card-subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 16px;
            padding: 12px;
            font-weight: 500;
            min-height: 44px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .mb-3 {
            margin-bottom: 1.25rem !important;
        }
        .form-section {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .section-title {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
        }
        #employee_id_loading {
            color: #007bff;
            font-weight: 500;
        }
        #employee_id_error {
            font-size: 13px;
            padding: 8px;
            background: #fff3cd;
            border-left: 3px solid #ffc107;
            border-radius: 4px;
            margin-top: 8px;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        @media (max-width: 576px) {
            body {
                font-size: 14px;
                padding: 5px 0;
                background-color: #f5f5f5;
            }
            .container-fluid {
                padding-left: 8px;
                padding-right: 8px;
            }
            .card-body {
                padding: 20px 15px;
            }
            .card-title {
                font-size: 20px;
                margin-bottom: 6px;
            }
            .card-subtitle {
                font-size: 12px;
                margin-bottom: 20px;
            }
            .form-control, .form-select {
                font-size: 16px;
                padding: 12px 14px;
                border-radius: 6px;
            }
            .form-label {
                font-size: 13px;
                margin-bottom: 8px;
            }
            .btn-primary {
                font-size: 16px;
                padding: 14px;
                width: 100%;
            }
            .success-icon {
                font-size: 48px;
            }
            .registration-id-value {
                font-size: 22px;
            }
            .form-section {
                padding: 15px;
                margin-bottom: 15px;
            }
            .section-title {
                font-size: 14px;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid px-2 px-md-3 mt-2 mt-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title">
                        <span class="running-icon">🏃</span>
                        Tanseeq Run - Season 3
                    </h3>
                    <span class="date-title">17th January 2026</span>
                    <p class="card-subtitle">Registration Form</p>

                    @if(session('success'))
                        <div class="success-container">
                            <div class="success-icon">✓</div>
                            <h4 class="text-success mb-4">Registration Successful!</h4>
                            <p class="mb-4">{{ session('success') }}</p>
                            @if(session('registration_id'))
                                <div class="registration-id-box">
                                    <div class="registration-id-label">Your Registration ID:</div>
                                    <div class="registration-id-value">{{ session('registration_id') }}</div>
                                </div>
                            @endif
                            <p class="text-muted mt-4" style="font-size: 12px;">
                                Please save your Registration ID for future reference.
                            </p>
                        </div>
                    @else

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/tanseeq-run" id="registrationForm">
                        @csrf

                        <div class="form-section">
                            <div class="section-title">Employee Information</div>
                            
                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Employee ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="employee_id" name="employee_id" 
                                       placeholder="Enter Employee ID" required autocomplete="off">
                                <div id="employee_id_error" class="text-danger mt-1" style="display: none;"></div>
                                <div id="employee_id_loading" class="text-info mt-1" style="display: none; font-size: 12px;">Looking up employee...</div>
                                <div id="employee_id_success" class="text-success mt-1" style="display: none; font-size: 12px;">✓ Employee found</div>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       placeholder="auto-filled" readonly required>
                            </div>

                            <div class="mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" 
                                       placeholder="auto-filled" readonly required>
                            </div>

                            <div class="mb-3">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="company" name="company" 
                                       placeholder="auto-filled" readonly required>
                            </div>

                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                       placeholder="Contact Number" required>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-title">Run Details</div>
                            
                            <div class="mb-3">
                                <label for="run_category" class="form-label">Run Category <span class="text-danger">*</span></label>
                                <select class="form-control form-select" id="run_category" name="run_category" required>
                                    <option value="">Select Category</option>
                                    <option value="2.5KM">2.5KM</option>
                                    <option value="5KM">5KM</option>
                                    <option value="10KM">10KM</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tshirt_size" class="form-label">T-Shirt Size <span class="text-danger">*</span></label>
                                <select class="form-control form-select" id="tshirt_size" name="tshirt_size" required>
                                    <option value="">Select Size</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                    <option value="XXXL">XXXL</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" style="margin-top: 10px;">
                            Register
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let employeeIdInput = document.getElementById('employee_id');
    let nameInput = document.getElementById('name');
    let designationInput = document.getElementById('designation');
    let companyInput = document.getElementById('company');
    let errorDiv = document.getElementById('employee_id_error');
    let loadingDiv = document.getElementById('employee_id_loading');
    let successDiv = document.getElementById('employee_id_success');
    let registrationForm = document.getElementById('registrationForm');
    let timeout;
    let employeeFound = false;

    if (employeeIdInput) {
        employeeIdInput.addEventListener('input', function() {
            clearTimeout(timeout);
            let employeeId = this.value.trim();
            
            // Clear previous data
            employeeFound = false;
            if (nameInput) {
                nameInput.value = '';
            }
            if (designationInput) {
                designationInput.value = '';
            }
            if (companyInput) {
                companyInput.value = '';
            }
            if (errorDiv) {
                errorDiv.style.display = 'none';
                errorDiv.textContent = '';
            }
            if (successDiv) {
                successDiv.style.display = 'none';
            }
            
            if (employeeId.length > 0) {
                timeout = setTimeout(function() {
                    // Show loading indicator
                    if (errorDiv) {
                        errorDiv.style.display = 'none';
                    }
                    if (successDiv) {
                        successDiv.style.display = 'none';
                    }
                    if (loadingDiv) {
                        loadingDiv.style.display = 'block';
                    }
                    
                    fetch('/api/employee?employee_id=' + encodeURIComponent(employeeId))
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(data => {
                                    throw new Error(data.error || 'Employee not found');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Employee data received:', data);
                            
                            if (data.error) {
                                employeeFound = false;
                                if (successDiv) {
                                    successDiv.style.display = 'none';
                                }
                                if (errorDiv) {
                                    let errorMsg = data.error;
                                    if (data.registration_id) {
                                        errorMsg += '<br>Registration ID: ' + data.registration_id;
                                    }
                                    errorDiv.innerHTML = errorMsg;
                                    errorDiv.style.display = 'block';
                                }
                                // Clear readonly fields
                                if (nameInput) {
                                    nameInput.value = '';
                                }
                                if (designationInput) {
                                    designationInput.value = '';
                                }
                                if (companyInput) {
                                    companyInput.value = '';
                                }
                            } else {
                                // Auto-fill readonly fields when employee found
                                employeeFound = true;
                                console.log('Auto-filling fields...');
                                if (nameInput && data.name) {
                                    nameInput.value = data.name;
                                }
                                if (designationInput && data.designation) {
                                    designationInput.value = data.designation;
                                }
                                // Use entity data for company field (since employee data has entity)
                                if (companyInput && data.entity) {
                                    companyInput.value = data.entity;
                                }
                                if (errorDiv) {
                                    errorDiv.style.display = 'none';
                                    errorDiv.textContent = '';
                                }
                                if (loadingDiv) {
                                    loadingDiv.style.display = 'none';
                                }
                                if (successDiv) {
                                    successDiv.style.display = 'block';
                                }
                                console.log('Fields auto-filled successfully');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching employee:', error);
                            employeeFound = false;
                            if (loadingDiv) {
                                loadingDiv.style.display = 'none';
                            }
                            if (successDiv) {
                                successDiv.style.display = 'none';
                            }
                            if (errorDiv) {
                                let errorMsg = error.message || 'Error fetching employee data. Please try again.';
                                errorDiv.textContent = errorMsg;
                                errorDiv.style.display = 'block';
                            }
                            // Clear readonly fields
                            if (nameInput) {
                                nameInput.value = '';
                            }
                            if (designationInput) {
                                designationInput.value = '';
                            }
                            if (companyInput) {
                                companyInput.value = '';
                            }
                        });
                }, 300); // Reduced to 300ms for faster response
            } else {
                // Clear fields when employee ID is empty
                employeeFound = false;
                if (nameInput) {
                    nameInput.value = '';
                }
                if (designationInput) {
                    designationInput.value = '';
                }
                if (companyInput) {
                    companyInput.value = '';
                }
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                    errorDiv.textContent = '';
                }
                if (successDiv) {
                    successDiv.style.display = 'none';
                }
                if (loadingDiv) {
                    loadingDiv.style.display = 'none';
                }
            }
        });
    }

    // Prevent form submission if employee is not found
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            if (!employeeFound) {
                e.preventDefault();
                if (errorDiv) {
                    errorDiv.textContent = 'Please enter a valid Employee ID before submitting.';
                    errorDiv.style.display = 'block';
                }
                if (employeeIdInput) {
                    employeeIdInput.focus();
                }
                return false;
            }
        });
    }
</script>
</body>
</html>
