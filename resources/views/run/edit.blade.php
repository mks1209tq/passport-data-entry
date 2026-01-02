<!DOCTYPE html>
<html>
<head>
    <title>Edit Registration - Tanseeq Run</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-control:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title mb-4">Edit Registration</h3>
                    <p class="text-muted">Registration ID: <strong>{{ $registration->registration_id }}</strong></p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('registrations.update', $registration->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" 
                                   value="{{ $registration->employee_id }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ $registration->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="designation" name="designation" 
                                   value="{{ $registration->designation }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="company" class="form-label">Department/Projects <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="company" name="company" 
                                   value="{{ $registration->company }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="entity" class="form-label">Entity <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="entity" name="entity" 
                                   value="{{ $registration->entity }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                   value="{{ $registration->contact_number }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="run_category" class="form-label">UN Category <span class="text-danger">*</span></label>
                            <select class="form-control form-select" id="run_category" name="run_category" required>
                                <option value="2.5KM" {{ $registration->run_category == '2.5KM' ? 'selected' : '' }}>2.5KM</option>
                                <option value="5KM" {{ $registration->run_category == '5KM' ? 'selected' : '' }}>5KM</option>
                                <option value="10KM" {{ $registration->run_category == '10KM' ? 'selected' : '' }}>10KM</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tshirt_size" class="form-label">T-Shirt Size <span class="text-danger">*</span></label>
                            <select class="form-control form-select" id="tshirt_size" name="tshirt_size" required>
                                <option value="S" {{ $registration->tshirt_size == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ $registration->tshirt_size == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ $registration->tshirt_size == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ $registration->tshirt_size == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ $registration->tshirt_size == 'XXL' ? 'selected' : '' }}>XXL</option>
                                <option value="XXXL" {{ $registration->tshirt_size == 'XXXL' ? 'selected' : '' }}>XXXL</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('registrations.list') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

