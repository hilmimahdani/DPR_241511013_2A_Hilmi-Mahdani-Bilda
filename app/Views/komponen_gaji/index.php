<!DOCTYPE html>
<html lang="id">
<head><title>Komponen Gaji</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="container mt-5">
    <div class="card"><div class="card-header">Komponen Gaji</div><div class="card-body">
        <a href="<?= base_url('komponen_gaji/create') ?>" class="btn btn-primary mb-3">Tambah</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Komponen</th>
                    <th>Kategori</th>
                    <th>Jabatan</th>
                    <th>Nominal</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($komponen as $k): ?>
                <tr>
                    <td><?= $k['id_komponen_gaji'] ?></td>
                    <td><?= $k['nama_komponen'] ?></td>
                    <td><?= $k['kategori'] ?></td>
                    <td><?= $k['jabatan'] ?></td>
                    <td><?= $k['nominal'] ?></td>
                    <td><?= $k['satuan'] ?></td>
                    <td>
                    <a href="<?= base_url('komponen_gaji/edit/' . $k['id_komponen_gaji']) ?>" 
                    class="btn btn-warning">Edit</a>
                    <a href="<?= base_url('komponen_gaji/delete/' . $k['id_komponen_gaji']) ?>"
                    class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">🗑 Hapus</a>
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