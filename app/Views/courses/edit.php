<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Edit Course</h2>
    <form method="post" action="<?= base_url('courses/update/'.$course['id']) ?>">
        <div class="mb-3">
            <label>Nama Course</label>
            <input type="text" name="name" class="form-control" value="<?= esc($course['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required><?= esc($course['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('courses') ?>" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
