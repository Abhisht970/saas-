<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ app('currentTenant')->name }} CRM Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #e9eef5);
            min-height: 100vh;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .login-header {
            background: #212529;
            color: white;
            padding: 32px 30px;
            text-align: center;
        }

        .login-header h2 {
            margin-bottom: 6px;
            font-weight: 700;
        }

        .login-header p {
            margin: 0;
            opacity: 0.75;
            font-size: 14px;
        }

        .login-body {
            background: #ffffff;
            padding: 35px;
        }

        .form-control {
            min-height: 48px;
            border-radius: 10px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #212529;
        }

        .btn-login {
            min-height: 48px;
            border-radius: 10px;
            font-weight: 600;
        }

        .tenant-name {
            font-size: 24px;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #6c757d;
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div class="card login-card">

        <!-- Header -->
        <div class="login-header">
            <h2 class="tenant-name">
                {{ app('currentTenant')->name }}
            </h2>

            <p>CRM Login</p>
        </div>


        <!-- Body -->
        <div class="login-body">

            <h4 class="fw-bold mb-1">Welcome Back</h4>
            <p class="text-muted mb-4">
                Please login to continue to your CRM.
            </p>


            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>
                </div>
            @endif


            <!-- Login Form -->
            <form method="POST" action="/login">

                @csrf


                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        autofocus
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Login Button -->
                <div class="d-grid">
                    <button
                        type="submit"
                        class="btn btn-dark btn-login">
                        Login
                    </button>
                </div>

            </form>


            <!-- Footer -->
            <div class="login-footer">
                © {{ date('Y') }}
                {{ app('currentTenant')->name }}
                CRM
            </div>

        </div>

    </div>

</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>