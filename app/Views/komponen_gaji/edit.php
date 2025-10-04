<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Komponen Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning">
            <h3>✏ Edit Komponen Gaji</h3>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('komponen_gaji/update/' . $komponen['id_komponen_gaji']) ?>">
                <div class="mb-3">
                    <label>Nama Komponen</label>
                    <input type="text" name="nama_komponen" class="form-control" value="<?= esc($komponen['nama_komponen']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="<?= esc($komponen['kategori']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="<?= esc($komponen['jabatan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Nominal</label>
                    <input type="number" name="nominal" class="form-control" value="<?= esc($komponen['nominal']) ?>" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label>Satuan</label>
                    <select name="satuan" class="form-control" required>
                        <option value="Bulanan" <?= $komponen['satuan'] == 'Bulanan' ? 'selected' : '' ?>>Bulanan</option>
                        <option value="Tahunan" <?= $komponen['satuan'] == 'Tahunan' ? 'selected' : '' ?>>Tahunan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('komponen_gaji') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>