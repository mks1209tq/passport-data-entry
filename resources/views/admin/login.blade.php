<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Tanseeq Run</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow login-card">
                    <div class="card-body p-5">
                        <h3 class="card-title text-center mb-4">Admin Login</h3>
                        <p class="text-center text-muted mb-4">Tanseeq Run Registration System</p>

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

                        <form method="POST" action="{{ route('admin.login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email (Optional)</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Enter your email (optional)" value="{{ old('email') }}" autofocus>
                                <small class="text-muted">Leave empty to use admin password</small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Enter password" required>
                                <small class="text-muted">Use your account password or admin password</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="{{ route('admin.register') }}" class="text-primary" style="text-decoration: none;">
                                Create Admin Account
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

