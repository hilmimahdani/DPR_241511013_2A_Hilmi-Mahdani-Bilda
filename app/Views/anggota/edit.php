<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning">
            <h3>✏ Edit Anggota</h3>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('anggota/update/'.$anggota['id_anggota']) ?>">
                <div class="mb-3">
                    <label>Gelar Depan</label>
                    <input type="text" name="gelar_depan" class="form-control" value="<?= esc($anggota['gelar_depan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Nama Depan</label>
                    <input type="text" name="nama_depan" class="form-control" value="<?= esc($anggota['nama_depan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Nama Belakang</label>
                    <input type="text" name="nama_belakang" class="form-control" value="<?= esc($anggota['nama_belakang']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Gelar Belakang</label>
                    <input type="text" name="gelar_belakang" class="form-control" value="<?= esc($anggota['gelar_belakang']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="<?= esc($anggota['jabatan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Status Pernikahan</label>
                    <input type="text" name="status_pernikahan" class="form-control" value="<?= esc($anggota['status_pernikahan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Jumlah Anak</label>
                    <input type="number" name="jumlah_anak" class="form-control" value="<?= esc($anggota['jumlah_anak']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('anggota') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
