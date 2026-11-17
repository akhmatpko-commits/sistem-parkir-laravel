
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Parkir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,.2);
        }

        .login-icon {
            width: 70px;
            height: 70px;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            font-size: 35px;
        }

        .form-control {
            padding: 12px;
            border-radius: 10px;
        }

        .btn-login {
            padding: 12px;
            border-radius: 10px;
            background: #1d4ed8;
            color: white;
            font-weight: bold;
        }

        .btn-login:hover {
            background: #1e40af;
            color: white;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="text-center mb-4">

        <div class="login-icon mb-3">
            <i class="bi bi-car-front-fill"></i>
        </div>

        <h3 class="fw-bold">Akhmat Nurhadi APP</h3>

        <p class="text-muted">
            Silakan login untuk melanjutkan
        </p>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label fw-semibold">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Masukkan email"
                value="{{ old('email') }}"
                required
                autofocus
            >

        </div>

        <div class="mb-3">

            <label class="form-label fw-semibold">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            >

        </div>

        <div class="mb-3 form-check">

            <input
                type="checkbox"
                name="remember"
                value="1"
                class="form-check-input"
                id="remember"
            >

            <label class="form-check-label" for="remember">
                Ingat saya
            </label>

        </div>

        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>
            Login
        </button>

    </form>

    <div class="text-center mt-4">

        <small class="text-muted">
            &copy; {{ date('Y') }} Sistem Manajemen Parkir
        </small>

    </div>

</div>

</body>
</html>
