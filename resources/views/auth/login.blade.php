<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #007bff; /* Biru primer (sesuaikan) */
            --form-bg: #ffffff;
            --page-bg: #f4f7f6;
            --text-color: #333;
            --input-border: #e0e0e0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--page-bg);
            margin: 0;
            padding: 0;
            /* Memastikan body memenuhi seluruh layar */
            min-height: 100vh;
        }

        .login-container-fluid {
            min-height: 100vh;
            padding: 0;
        }

        .login-row {
            min-height: 100vh;
        }

        /* Sisi Kiri (Biru) */
        .login-image-side {
            background-color: var(--primary-color);
            /* Diberi gambar background (opsional, sesuai UI) */
            /* background-image: url('URL_GAMBAR_BACKGROUND_BIRU_ANDA'); */
            background-size: cover;
            background-position: center;
        }

        /* Sisi Kanan (Form Putih) */
        .login-form-side {
            background-color: var(--form-bg);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            min-height: 100vh; /* Pastikan tinggi penuh di mobile */
        }
        
        .login-form-wrapper {
            max-width: 450px;
            width: 100%;
            z-index: 10;
        }
        
        /* EFEK GELOMBANG (Wave Effect) */
        @media (min-width: 992px) {
            .login-form-side::before {
                content: '';
                position: absolute;
                top: 50%;
                left: -1000px; /* Tarik ke kiri */
                transform: translateY(-50%);
                width: 2000px; /* Lingkaran besar */
                height: 2000px; /* Lingkaran besar */
                background-color: var(--form-bg);
                border-radius: 50%;
                z-index: 1;
            }
            .login-form-wrapper {
                position: relative;
                z-index: 2; /* Pastikan form di atas gelombang */
            }
        }

        .login-logo {
            max-height: 80px;
            margin-bottom: 1.5rem;
        }

        .login-title {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .login-subtitle {
            color: #6c757d;
            margin-bottom: 2.5rem;
        }
        
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-color);
            text-transform: uppercase;
        }
        
        .input-group-text {
            background-color: transparent;
            border-right: 0;
            color: #adb5bd;
        }
        
        .form-control {
            border-left: 0;
            padding-left: 0;
            height: 50px;
            box-shadow: none;
            border-color: var(--input-border);
        }
        .form-control:focus {
            border-color: var(--primary-color);
        }

        /* Khusus untuk input-group */
        .input-group .form-control {
            border-right: 1px solid var(--input-border);
        }
        .input-group .form-control:focus {
             border-right: 1px solid var(--primary-color);
        }
        
        /* Tombol Toggle Password */
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            cursor: pointer;
            color: #adb5bd;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,123,255,0.3);
        }

    </style>
</head>
<body>

    <div class="container-fluid login-container-fluid">
        <div class="row g-0 login-row">

            <!-- Sisi Kiri (Gambar Biru) - Hilang di mobile -->
            <div class="col-lg-5 d-none d-lg-block login-image-side">
                {{-- Anda bisa meletakkan konten di sini jika mau --}}
            </div>

            <!-- Sisi Kanan (Form) -->
            <div class="col-lg-7 col-12 login-form-side">
                <div class="login-form-wrapper text-center">

                    <!-- Logo -->
                    <img src="https://placehold.co/150x80/007bff/white?text=LOGO" alt="Logo Diskominfo" class="login-logo">

                    <!-- Judul -->
                    <h1 class="login-title">WELCOME</h1>
                    <p class="login-subtitle">Silahkan login dengan menggunakan akun Anda</p>

                    <!-- Form Login -->
                    <form method="POST" action="{{ route('login') }}" class="text-start">
                        @csrf

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Pesan Error Global (Dari Breeze) -->
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="asepcowboy@email.co.id" required autofocus>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group position-relative">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="•••••••••" required autocomplete="current-password">
                                <span class="password-toggle" id="togglePassword">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Remember Me & Lupa Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label" for="remember_me">
                                    {{ __('Remember me') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="small text-decoration-none" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        
                        <!-- Tombol Login -->
                        <button type="submit" class="btn btn-primary w-100 btn-login">
                            {{ __('Log in') }}
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Diperlukan untuk form) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript untuk Toggle Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    // Toggle tipe input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Toggle ikon
                    this.querySelector('i').classList.toggle('bi-eye');
                    this.querySelector('i').classList.toggle('bi-eye-slash');
                });
            }
        });
    </script>
</body>
</html>