<!DOCTYPE html>
<html lang="id">
<head><title>Tambah Komponen Gaji</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="container mt-5">
    <div class="card"><div class="card-header">Tambah Komponen Gaji</div><div class="card-body">
        <form method="post" action="<?= base_url('komponen_gaji/store') ?>">
            <div class="mb-3"><input type="text" name="nama_komponen" class="form-control" placeholder="Nama Komponen" required></div>
            <div class="mb-3"><input type="text" name="kategori" class="form-control" placeholder="Kategori" required></div>
            <div class="mb-3"><input type="text" name="jabatan" class="form-control" placeholder="Jabatan" required></div>
            <div class="mb-3"><input type="number" name="nominal" class="form-control" placeholder="Nominal" step="0.01" required></div>
            <div class="mb-3"><select name="satuan" class="form-control" required><option value="Bulanan">Bulanan</option><option value="Tahunan">Tahunan</option></select></div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form></div></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>