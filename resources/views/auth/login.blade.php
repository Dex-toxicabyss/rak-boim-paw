<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Rak Boim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100 py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="card border shadow-sm">
                <div class="card-header bg-dark text-white text-center py-4">
                    <h1 class="h4 fw-bold mb-1">RAK BOIM</h1>
                    <p class="small text-secondary mb-0">Aplikasi Pengelolaan Gudang Boim Laundry</p>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success small">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger small mb-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="pemilik@boimlaundry.test" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label small">Ingat sesi saya</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">Masuk ke Sistem</button>
                    </form>

                    <div class="mt-4 p-3 bg-light border rounded small">
                        <div class="fw-semibold mb-1">Akun Demo Seeder:</div>
                        <div>Pemilik: <code>pemilik@boimlaundry.test</code> / <code>password123</code></div>
                        <div>Staf: <code>staf@boimlaundry.test</code> / <code>password123</code></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
