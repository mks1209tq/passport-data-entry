<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration - Tanseeq Run</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .register-card {
            max-width: 450px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow register-card">
                    <div class="card-body p-5">
                        <h3 class="card-title text-center mb-4">Create Admin Account</h3>
                        <p class="text-center text-muted mb-4">Tanseeq Run Registration System</p>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Enter your email" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Enter password (min 8 characters)" required>
                                <small class="text-muted">Password must be at least 8 characters long</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                                       placeholder="Confirm your password" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Create Account</button>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.login') }}" class="text-primary" style="text-decoration: none;">
                                Already have an account? Login here
                            </a>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="/tanseeq-run" class="text-muted" style="text-decoration: none;">
                                ← Back to Registration
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

