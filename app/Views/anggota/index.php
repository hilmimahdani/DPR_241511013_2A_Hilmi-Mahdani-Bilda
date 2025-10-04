<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota DPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3>Daftar Anggota DPR</h3>
            <a href="<?= base_url('anggota/create') ?>" class="btn btn-light btn-sm">+ Tambah Anggota</a>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID Anggota</th>
                        <th>Gelar Depan</th>
                        <th>Nama Depan </th>
                        <th>Nama Belakang</th>
                        <th>Gelar Belakang</th>
                        <th>Jabatan</th>
                        <th>Status Pernikahan</th>
                        <th>Jumlah Anak</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($anggota)): ?>
                        <?php foreach($anggota as $s): ?>
                            <tr>
                                <td><?= esc($s['id_anggota']) ?></td>
                                <td><?= esc($s['gelar_depan']) ?></td>
                                <td><?= esc($s['nama_depan']) ?></td>
                                <td><?= esc($s['nama_belakang']) ?></td>
                                <td><?= esc($s['gelar_belakang']) ?></td>
                                <td><?= esc($s['jabatan']) ?></td>
                                <td><?= esc($s['status_pernikahan']) ?></td>
                                <td><?= esc($s['jumlah_anak']) ?></td>
                                <td>
                                    <a href="<?= base_url('anggota/edit/'.$s['id_anggota']) ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <a href="<?= base_url('anggota/delete/'.$s['id_anggota']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">🗑 Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">Belum ada anggota</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <a href="<?= base_url('home') ?>" class="btn btn-secondary">⬅ Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
