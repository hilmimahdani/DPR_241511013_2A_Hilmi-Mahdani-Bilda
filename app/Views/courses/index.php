<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Courses</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Daftar Courses</h2>

    <!-- Notifikasi sukses/error -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Tombol tambah khusus admin -->
    <?php if (session()->get('role') === 'admin'): ?>
        <a href="<?= base_url('courses/create') ?>" class="btn btn-success mb-3">+ Tambah Course</a>
    <?php endif; ?>

    <!-- Tabel Courses -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th width="25%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($courses as $c): ?>
                <tr>
                    <td><?= esc($c['name']) ?></td>
                    <td><?= esc($c['description']) ?></td>
                    <td>
                        <a href="<?= base_url('courses/detail/'.$c['id']) ?>" class="btn btn-info btn-sm">Detail</a>

                        <?php if (session()->get('role') === 'admin'): ?>
                            <a href="<?= base_url('courses/edit/'.$c['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('courses/delete/'.$c['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
                        <?php else: ?>
                            <form method="post" action="<?= base_url('courses/enroll/'.$c['id']) ?>" style="display:inline">
                                <button type="submit" class="btn btn-primary btn-sm">Enroll</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tombol kembali -->
    <a href="<?= base_url('home') ?>" class="btn btn-secondary">⬅ Kembali ke Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
