<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3>📘 Detail Course</h3>
        </div>
        <div class="card-body">
            <?php if(!empty($course)): ?>
                <p><b>Nama:</b> <?= esc($course['name']) ?></p>
                <p><b>Deskripsi:</b> <?= esc($course['description']) ?></p>
            <?php else: ?>
                <div class="alert alert-warning">⚠️ Course tidak ditemukan.</div>
            <?php endif; ?>

            <a href="<?= base_url('courses') ?>" class="btn btn-secondary mt-3">
                ⬅ Kembali ke daftar
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
