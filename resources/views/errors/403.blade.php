<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
<div class="container text-center">
    <div class="card border shadow-sm mx-auto p-5" style="max-width: 480px;">
        <h1 class="display-4 fw-bold text-danger mb-2">403</h1>
        <h2 class="h5 fw-semibold mb-3">Akses Ditolak</h2>
        <p class="text-muted mb-4">{{ $exception->getMessage() ?: 'Peran akun Anda tidak memiliki izin untuk membuka halaman ini.' }}</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
