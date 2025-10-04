<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penggajian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h3>➕ Tambah Penggajian</h3>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('penggajian/store') ?>">
                <div class="mb-3">
                    <label>Anggota</label>
                    <select name="id_anggota" class="form-control" required>
                        <?php foreach ($anggota as $a) : ?>
                            <option value="<?= esc($a['id_anggota']) ?>"><?= esc($a['nama_depan'] . ' ' . $a['nama_belakang']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Komponen Gaji</label>
                    <select name="id_komponen_gaji" class="form-control" required>
                        <?php foreach ($komponen as $k) : ?>
                            <option value="<?= esc($k['id_komponen_gaji']) ?>"><?= esc($k['nama_komponen']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('penggajian') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>