<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Login - Tanseeq Run</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 10px;
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
        }
        .form-control {
            font-size: 16px;
            padding: 12px;
            height: auto;
        }
        .form-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .btn {
            font-size: 16px;
            padding: 12px;
            font-weight: 500;
            min-height: 44px;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 20px;
        }
        @media (max-width: 576px) {
            body {
                padding: 5px;
                font-size: 14px;
            }
            .card-body {
                padding: 15px;
            }
            .card-title {
                font-size: 18px;
                margin-bottom: 15px;
            }
            .form-control {
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
            small {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-2 px-md-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
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
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
                                <small class="text-muted">Enter your admin email address</small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Enter your password" required>
                                <small class="text-muted">Enter your account password</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        <div class="mt-3 text-center">
                            <p class="text-muted small mb-2">Super admins can create new admin accounts after logging in.</p>
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

