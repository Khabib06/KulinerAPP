<!DOCTYPE html>
<html>
<head>
    <title>Pending Places</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body style="min-height:100vh; display:flex; flex-direction:column;">

<?= view('layout/navbar'); ?>

<div class="container mt-5" style="flex:1;">

    <h1 class="mb-4">
        Tempat Kuliner Pending
    </h1>

    <table class="table table-bordered">

        <tr>
            <th>Nama Tempat</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($places as $place): ?>

        <tr>

            <td><?= $place['nama_tempat']; ?></td>

            <td><?= $place['alamat']; ?></td>

            <td>

    <a href="/place/approve/<?= $place['id']; ?>"
       class="btn btn-success btn-sm">
        ✅ Approve
    </a>

    <a href="/place/delete/<?= $place['id']; ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Yakin ingin menghapus tempat ini?')">
        🗑 Delete
    </a>

</td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>
<?= view('layout/footer'); ?>
</body>
</body>
</html>