<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3>👨‍🎓 Daftar Anggota DPR/h3>
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
                        <th>Nama </th>
                        <th>Usia</th>
                        <th>Entry Year</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($students)): ?>
                        <?php foreach($students as $s): ?>
                            <tr>
                                <td><?= esc($s['nim']) ?></td>
                                <td><?= esc($s['full_name']) ?></td>
                                <td><?= esc($s['age']) ?></td>
                                <td><?= esc($s['entry_year']) ?></td>
                                <td><?= esc($s['username']) ?></td>
                                <td><?= esc($s['email']) ?></td>
                                <td>
                                    <a href="<?= base_url('students/edit/'.$s['student_id']) ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <a href="<?= base_url('students/delete/'.$s['student_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">🗑 Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">Belum ada mahasiswa</td></tr>
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
