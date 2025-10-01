<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body text-center p-5">
                <h2 class="fw-bold mb-3 text-primary">Selamat Datang, <?= esc($username) ?>!</h2>
                <p class="lead text-muted">Anda login sebagai <span class="fw-bold"><?= esc($role) ?></span></p>
                
                <hr class="my-4">

                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= base_url('courses') ?>" class="btn btn-success btn-lg px-4">
                        📚 Daftar Courses
                    </a>
                    <?php if ($role === 'admin'): ?>
                    <a href="<?= base_url('students') ?>" class="btn btn-warning btn-lg px-4">
                        👥 Kelola Students
                    </a>
                    <?php endif; ?>

                    <?php if ($role === 'student'): ?>
                    
                    <a href="<?= base_url('mycourses') ?>" class="btn btn-info btn-lg px-4">
                        📖 My Courses
                    </a>
                    <?php endif; ?>


                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-lg px-4">
                        🚪 Logout

                    </a>
 

                </div>
                    
                <?php if ($role === 'student' && !empty($student)): ?>
                        <div class="alert alert-info mt-3 text-start">
                            <h5>Identitas Mahasiswa</h5>
                            <p><b>NIM:</b> <?= esc($student['nim']) ?></p>
                            <p><b>Nama:</b> <?= esc($student['full_name']) ?></p>
                            <p><b>Usia:</b> <?= esc($student['age']) ?></p>
                            <p><b>Entry Year:</b> <?= esc($student['entry_year']) ?></p>
                        </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

