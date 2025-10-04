<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Aplikasi Gaji DPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center">
            <h3>📊 Dashboard Admin</h3>
        </div>
        <div class="card-body">
            <h4>Selamat datang, <?= session()->get('username') ?>!</h4>
            <p>Anda login sebagai <?= session()->get('role') ?></p>
            <div class="mb-3">  
                <a href="<?= base_url('anggota') ?>" class="btn btn-primary me-2">Kelola Anggota DPR</a>
                <a href="<?= base_url('komponen_gaji') ?>" class="btn btn-primary me-2">Kelola Komponen Gaji</a>
                <a href="<?= base_url('penggajian') ?>" class="btn btn-primary">Kelola Penggajian</a>
            </div>
            <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>