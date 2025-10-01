<!DOCTYPE html>
<html>
<head>
    <title>Kelola Data Anggota DPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Kelola Data Anggota DPR</h2>
    <form method="post" action="<?= base_url('courses/store') ?>">
        <div class="mb-3">
            <label>Nama Anggota</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('courses') ?>" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
