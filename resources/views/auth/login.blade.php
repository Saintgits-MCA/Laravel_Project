<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Laravel Project</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/nav.css') }}" rel="stylesheet">

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <style>


/* Navbar */


/* Login Section */
.login-wrapper {
    flex: 1 0 auto;
    width: 100%;
    min-height: calc(100vh - 135px);
    display: grid !important;
    place-items: center !important;
    margin:auto;
    padding: 40px 15px;
    background: linear-gradient(
        110deg,
        #ff8589 0%,
        #ffe5e6 45%,
        #fffafa 85%
    );
}

/* Login Card */
.login-card {
    width: 100%;
    max-width: 620px;
    padding: 35px;
    border-radius: 15px;
    background: #ffffff;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.10);
}

.login-heading {
    color: #dc3545;
    font-weight: bold;
}

.login-card .form-control {
    padding: 12px;
}

.login-btn {
    width: 100%;
    padding: 12px;
    font-weight: 600;
}

/* Footer */
footer {
    width: 100%;
    flex-shrink: 0;
}

/* Mobile */
@media (max-width: 576px) {
    .login-wrapper {
        padding: 25px 15px;
    }

    .login-card {
        padding: 25px 20px;
    }
}
    </style>
</head>

<body>
<x-navbar/>
    <div class="login-card  mx-auto my-2 w-100">

        <div class="text-center mb-4">

            <i class="bi bi-person-circle text-danger"
               style="font-size: 55px;"></i>

            <h3 class="login-heading mt-2">Welcome Back</h3>

            <p class="text-muted">
                Login to your account
            </p>

        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">

            @csrf

            {{-- Email --}}
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Email Address
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your email"
                       value="{{ old('email') }}"
                       required
                       autofocus>

            </div>

            {{-- Password --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Password
                </label>

                <div class="input-group">

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           placeholder="Enter your password"
                           required>

                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword()">

                        <i class="bi bi-eye" id="passwordEye"></i>

                    </button>

                </div>

            </div>

            {{-- Login Button --}}
            <button type="submit"
                    class="btn btn-danger login-btn">

                <i class="bi bi-box-arrow-in-right me-2"></i>

                Login

            </button>

        </form>

    </div>
<x-footer/>

    <script>
        function togglePassword() {

            const password = document.getElementById('password');
            const eye = document.getElementById('passwordEye');

            if (password.type === 'password') {

                password.type = 'text';

                eye.classList.remove('bi-eye');
                eye.classList.add('bi-eye-slash');

            } else {

                password.type = 'password';

                eye.classList.remove('bi-eye-slash');
                eye.classList.add('bi-eye');

            }
        }
    </script>
</body>
</html>
