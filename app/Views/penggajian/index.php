<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penggajian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white">
            <h3>📋 Daftar Penggajian</h3>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <a href="<?= base_url('penggajian/create') ?>" class="btn btn-success mb-3">Tambah Penggajian</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Anggota</th>
                        <th>Nama Anggota</th>
                        <th>ID Komponen Gaji</th>
                        <th>Nama Komponen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penggajian as $p) : ?>
                        <tr>
                            <td><?= esc($p['id_anggota']) ?></td>
                            <td><?= esc($p['nama_depan'] . ' ' . $p['nama_belakang']) ?></td>
                            <td><?= esc($p['id_komponen_gaji']) ?></td>
                            <td><?= esc($p['nama_komponen']) ?></td>
                            <td>
                                <a href="<?= base_url('penggajian/edit/' . $p['id_komponen_gaji'] . '/' . $p['id_anggota']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('penggajian/delete/' . $p['id_komponen_gaji'] . '/' . $p['id_anggota']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?= base_url('home') ?>" class="btn btn-secondary">⬅ Kembali ke Dashboard</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>