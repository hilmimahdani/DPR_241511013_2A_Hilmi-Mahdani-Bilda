<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penggajian - Publik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white">
            <h3>📋 Detail Penggajian - <?= esc($anggota['nama_depan'] . ' ' . $anggota['nama_belakang']) ?></h3>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Komponen Gaji</th>
                        <th>Kategori</th>
                        <th>Nominal</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penggajian as $p) : ?>
                        <tr>
                            <td><?= esc($p['nama_komponen']) ?></td>
                            <td><?= esc($p['kategori']) ?></td>
                            <td><?= esc(number_format($p['nominal'], 2)) ?></td>
                            <td><?= esc($p['satuan']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?= base_url('public/penggajian') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>