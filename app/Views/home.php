<!DOCTYPE html>
<html>
<head>
    <title>Kuliner Sekitar Kampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body style="min-height:100vh; display:flex; flex-direction:column;">

<?= view('layout/navbar'); ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success m-3">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="container mt-5" style="flex:1;">

    <h1 class="text-center mb-4">
        Kuliner Sekitar Kampus UDINUS
    </h1>

    <!-- SEARCH -->
    <form method="get" action="/" class="mb-3">
        <div class="input-group">
            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="Cari tempat kuliner...">

            <button class="btn btn-dark">Cari</button>
        </div>
    </form>

    <!-- MAP -->
    <div id="map" style="height: 400px;" class="mb-4"></div>

    <!-- LIST -->
    <div class="row">

        <?php foreach ($places as $place): ?>

        <div class="col-md-6 mb-4">

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div style="flex:1; padding-right:15px;">

                            <h4>
                                <?= esc($place['nama_tempat']); ?>

                                <?php if ($place['is_promoted'] == 1): ?>
                                    <span class="badge bg-warning text-dark">
                                        ⭐ PROMOTED
                                    </span>
                                <?php endif; ?>
                            </h4>
                            <p><?= $place['alamat']; ?></p>
                            <p><?= $place['deskripsi']; ?></p>

                            <span class="badge bg-success">Approved</span>

<?php if (session()->get('logged_in')): ?>

    <div class="mt-2">

        <?php if ($place['is_promoted'] == 1): ?>

            <button class="btn btn-success btn-sm" disabled>
                ✅ Sedang Dipromosikan
            </button>

        <?php else: ?>

            <a href="<?= base_url('payment/' . $place['id']) ?>"
               class="btn btn-primary btn-sm">
                🚀 Promosikan Tempat
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>

<?php if (session()->get('role') == 'admin'): ?>
                                <div class="mt-2">

                                    <a href="/place/edit/<?= $place['id']; ?>" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <a href="/place/delete/<?= $place['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin hapus data?')">
                                        Delete
                                    </a>

                                    <a href="/place/approve/<?= $place['id']; ?>" class="btn btn-success btn-sm">
                                        Approve
                                    </a>

                                </div>
                            <?php endif; ?>

                        </div>

                        <div style="width:200px;">
                            <img src="<?= base_url('uploads/' . $place['foto']); ?>"
                                 style="width:100%; height:140px; object-fit:cover; border-radius:10px;">
                        </div>

                    </div>

                    <hr>

                    <!-- REVIEW FORM -->
                    <?php if (session()->get('logged_in')): ?>

                        <form action="/place/review/<?= $place['id']; ?>" method="post">

                            <select name="rating" class="form-control mb-2">
                                <option value="5">⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>
                            </select>

                            <textarea name="komentar"
                                      class="form-control mb-2"
                                      placeholder="Tulis review..."></textarea>

                            <button class="btn btn-dark btn-sm">Kirim Review</button>

                        </form>

                    <?php else: ?>
                        <small class="text-muted">
                            Login untuk memberi review
                        </small>
                    <?php endif; ?>

                    <!-- REVIEW LIST (DROP DOWN LOGIC) -->
                    <div class="mt-3">

                        <h6>Review:</h6>

                        <?php $total = count($place['reviews'] ?? []); ?>

                        <?php if ($total == 0): ?>

                            <small>Belum ada review</small>

                        <?php elseif ($total == 1): ?>

                            <?php $review = $place['reviews'][0]; ?>
                            <div class="border p-2 mb-2">
                                <b>⭐ <?= $review['rating']; ?>/5</b>
                                <p class="mb-0"><?= $review['komentar']; ?></p>
                            </div>

                        <?php else: ?>

                            <div class="dropdown">

                                <button class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    Lihat Review (<?= $total ?>)
                                </button>

                                <ul class="dropdown-menu p-2" style="width:300px;">

                                    <?php foreach ($place['reviews'] as $review): ?>

                                        <li class="mb-2 border-bottom pb-2">
                                            <b>⭐ <?= $review['rating']; ?>/5</b><br>
                                            <small><?= $review['komentar']; ?></small>
                                        </li>

                                    <?php endforeach; ?>

                                </ul>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div>

<script>

const map = L.map('map').setView([-6.9825,110.4091],15);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'&copy; OpenStreetMap'
}).addTo(map);

const bounds = [];

<?php foreach($places as $place): ?>

<?php if(!empty($place['latitude']) && !empty($place['longitude'])): ?>

L.marker([
    <?= $place['latitude']; ?>,
    <?= $place['longitude']; ?>
])
.addTo(map)
.bindPopup(`
<div style="min-width:220px">

<img src="<?= base_url('uploads/'.$place['foto']); ?>"
style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:8px;">

<h6><?= esc($place['nama_tempat']); ?></h6>

<p><?= esc($place['alamat']); ?></p>

<a href="https://www.google.com/maps?q=<?= $place['latitude']; ?>,<?= $place['longitude']; ?>"
target="_blank"
class="btn btn-primary btn-sm">
Lihat di Google Maps
</a>

</div>
`);

bounds.push([
<?= $place['latitude']; ?>,
<?= $place['longitude']; ?>
]);

<?php endif; ?>

<?php endforeach; ?>

if(bounds.length){
    map.fitBounds(bounds,{
        padding:[50,50]
    });
}

</script>

<?= view('layout/footer'); ?>

</body>
</html>