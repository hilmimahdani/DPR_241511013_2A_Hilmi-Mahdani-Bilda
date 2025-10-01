<!DOCTYPE html>
<html>
<head>
    <title>My Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3>Courses yang Sudah di Enroll</h3>
        </div>
        <div class="card-body">
            <?php if(!empty($courses)): ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Course</th>
                        <th>Deskripsi</th>
                    </tr>
                    <?php foreach($courses as $c): ?>
                        <tr>
                            <td><?= esc($c['name']) ?></td>
                            <td><?= esc($c['description']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="text-muted">Kamu belum mengambil course apapun.</p>
            <?php endif; ?>
            <a href="<?= base_url('home') ?>" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
