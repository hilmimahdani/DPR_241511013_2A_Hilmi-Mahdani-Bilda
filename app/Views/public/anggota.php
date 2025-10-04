<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik - Aplikasi Gaji DPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white text-center">
            <h3>📊 Dashboard Publik</h3>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <h4 class="mb-3">Daftar Anggota DPR</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota as $a): ?>
                        <tr>
                            <td><?= esc($a['id_anggota']) ?></td>
                            <td><?= esc($a['nama_depan'] . ' ' . $a['nama_belakang']) ?></td>
                            <td><?= esc($a['jabatan']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h4 class="mt-4 mb-3">Opsi Publik</h4>
            <div class="mb-3">
                <a href="<?= base_url('public/penggajian') ?>" class="btn btn-info me-2">📋 Lihat Daftar Penggajian</a>
                <?php if (!session()->get('logged_in')) : ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary">🔐 Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>