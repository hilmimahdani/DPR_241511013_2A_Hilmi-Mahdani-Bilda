<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota DPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h3>➕ Tambah Anggota DPR</h3>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('anggota/store') ?>">

                <hr>
                <h5 class="text-primary">📋 Identitas Anggota</h5>
                <!-- <div class="mb-3">
                    <label>ID Anggota</label>
                    <input type="number" name="id_anggota" class="form-control" required>
                </div> -->
                <div class="mb-3">
                    <label>Gelar Depan</label>
                    <input type="text" name="gelar_depan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama Depan</label>
                    <input type="text" name="nama_depan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama Belakang</label>
                    <input type="text" name="nama_belakang" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Gelar Belakang</label>
                    <input type="text" name="gelar_belakang" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Status Pernikahan</label>
                    <input type="text" name="status_pernikahan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jumlah Anak</label>
                    <input type="number" name="jumlah_anak" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('anggota') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
