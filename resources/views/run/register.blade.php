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
        }
        .form-control:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
        .form-control, .form-select {
            font-size: 16px;
            padding: 12px;
            height: auto;
        }
        .form-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .notes-section {
            font-size: 11px;
            color: #666;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 3px solid #007bff;
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
            background-color: #f8f9fa;
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
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        .card {
            border: none;
            border-radius: 10px;
        }
        .card-title {
            font-size: 20px;
            font-weight: 600;
        }
        .btn {
            font-size: 16px;
            padding: 12px;
            font-weight: 500;
            min-height: 44px;
        }
        .mb-3 {
            margin-bottom: 1rem !important;
        }
        @media (max-width: 576px) {
            body {
                font-size: 14px;
            }
            .container {
                padding-left: 10px;
                padding-right: 10px;
                margin-top: 10px !important;
            }
            .card-body {
                padding: 15px;
            }
            .card-title {
                font-size: 18px;
                margin-bottom: 20px;
            }
            .form-control, .form-select {
                font-size: 16px;
                padding: 10px;
            }
            .form-label {
                font-size: 13px;
            }
            .btn {
                font-size: 15px;
                padding: 10px;
            }
            .success-icon {
                font-size: 48px;
            }
            .registration-id-value {
                font-size: 20px;
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
                    <h3 class="card-title mb-4">Tanseeq Run – Registration</h3>

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

                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="employee_id" name="employee_id" 
                                   placeholder="Enter Employee ID" required autocomplete="off">
                            <div id="employee_id_error" class="text-danger mt-1" style="display: none;"></div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Full Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="designation" name="designation" 
                                   placeholder="Designation" required>
                        </div>

                        <div class="mb-3">
                            <label for="company" class="form-label">Department/Projects <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="company" name="company" 
                                   placeholder="Department/Projects" required>
                        </div>

                        <div class="mb-3">
                            <label for="entity" class="form-label">Entity <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="entity" name="entity" 
                                   placeholder="Entity" required>
                        </div>

                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                   placeholder="Contact Number" required>
                        </div>

                        <div class="mb-3">
                            <label for="run_category" class="form-label"> Category <span class="text-danger">*</span></label>
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

                        <button type="submit" class="btn btn-primary w-100">Register</button>
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
    let entityInput = document.getElementById('entity');
    let errorDiv = document.getElementById('employee_id_error');
    let timeout;

    if (employeeIdInput) {
        employeeIdInput.addEventListener('input', function() {
            clearTimeout(timeout);
            let employeeId = this.value.trim();
            
            // Clear previous data and make fields editable
            if (nameInput) {
                nameInput.value = '';
                nameInput.removeAttribute('readonly');
            }
            if (designationInput) {
                designationInput.value = '';
                designationInput.removeAttribute('readonly');
            }
            if (companyInput) {
                companyInput.value = '';
                companyInput.removeAttribute('readonly');
            }
            if (entityInput) {
                entityInput.value = '';
                entityInput.removeAttribute('readonly');
            }
            if (errorDiv) {
                errorDiv.style.display = 'none';
                errorDiv.textContent = '';
            }
            
            if (employeeId.length > 0) {
                timeout = setTimeout(function() {
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
                            if (data.error) {
                                if (errorDiv) {
                                    let errorMsg = data.error;
                                    if (data.error.includes('not found')) {
                                        errorMsg += ' You can manually enter your details below.';
                                    }
                                    errorDiv.textContent = errorMsg;
                                    errorDiv.style.display = 'block';
                                    if (data.registration_id) {
                                        errorDiv.innerHTML += '<br>Registration ID: ' + data.registration_id;
                                    }
                                }
                                // Keep fields editable for manual entry
                                if (nameInput) {
                                    nameInput.value = '';
                                    nameInput.removeAttribute('readonly');
                                }
                                if (designationInput) {
                                    designationInput.value = '';
                                    designationInput.removeAttribute('readonly');
                                }
                                if (companyInput) {
                                    companyInput.value = '';
                                    companyInput.removeAttribute('readonly');
                                }
                                if (entityInput) {
                                    entityInput.value = '';
                                    entityInput.removeAttribute('readonly');
                                }
                            } else {
                                // Auto-fill and make readonly when employee found
                                if (nameInput) {
                                    nameInput.value = data.name || '';
                                    nameInput.setAttribute('readonly', 'readonly');
                                }
                                if (designationInput) {
                                    designationInput.value = data.designation || '';
                                    designationInput.setAttribute('readonly', 'readonly');
                                }
                                if (companyInput) {
                                    companyInput.value = data.department_projects || '';
                                    companyInput.setAttribute('readonly', 'readonly');
                                }
                                if (entityInput) {
                                    entityInput.value = data.entity || '';
                                    entityInput.setAttribute('readonly', 'readonly');
                                }
                                if (errorDiv) errorDiv.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            if (errorDiv) {
                                let errorMsg = error.message || 'Error fetching employee data. Please try again.';
                                if (errorMsg.includes('not found')) {
                                    errorMsg += ' You can manually enter your details below.';
                                }
                                errorDiv.textContent = errorMsg;
                                errorDiv.style.display = 'block';
                            }
                            // Keep fields editable for manual entry
                            if (nameInput) {
                                nameInput.value = '';
                                nameInput.removeAttribute('readonly');
                            }
                            if (designationInput) {
                                designationInput.value = '';
                                designationInput.removeAttribute('readonly');
                            }
                            if (companyInput) {
                                companyInput.value = '';
                                companyInput.removeAttribute('readonly');
                            }
                            if (entityInput) {
                                entityInput.value = '';
                                entityInput.removeAttribute('readonly');
                            }
                        });
                }, 500); // Wait 500ms after user stops typing
            }
        });
    }
</script>
</body>
</html>
