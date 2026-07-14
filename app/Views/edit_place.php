<!DOCTYPE html>
<html>
<head>
    <title>Edit Tempat Kuliner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<?= view('layout/navbar'); ?>

<div class="container mt-5">

    <h1 class="mb-4">Edit Tempat Kuliner</h1>

    <form action="/place/update/<?= $place['id']; ?>" method="post">

        <div class="mb-3">
            <label>Nama Tempat</label>
            <input
                type="text"
                name="nama_tempat"
                class="form-control"
                value="<?= $place['nama_tempat']; ?>"
                required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>

            <select name="category_id" class="form-control">

                <?php foreach ($categories as $category): ?>

                    <option
                        value="<?= $category['id']; ?>"
                        <?= $category['id'] == $place['category_id'] ? 'selected' : ''; ?>>

                        <?= $category['nama_kategori']; ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea
                name="alamat"
                class="form-control"
                rows="3"
                required><?= $place['alamat']; ?></textarea>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea
                name="deskripsi"
                class="form-control"
                rows="4"><?= $place['deskripsi']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Lokasi di Peta</label>
            <div id="map" style="height:400px; border-radius:10px;"></div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <label>Latitude</label>
                <input
                    type="text"
                    id="latitude"
                    name="latitude"
                    class="form-control"
                    value="<?= $place['latitude']; ?>"
                    readonly
                    required>
            </div>

            <div class="col-md-6">
                <label>Longitude</label>
                <input
                    type="text"
                    id="longitude"
                    name="longitude"
                    class="form-control"
                    value="<?= $place['longitude']; ?>"
                    readonly
                    required>
            </div>

        </div>

        <br>

        <button type="submit" class="btn btn-primary">
            Update
        </button>

    </form>

</div>

<?= view('layout/footer'); ?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

const defaultLat = <?= !empty($place['latitude']) ? $place['latitude'] : -6.9825 ?>;
const defaultLng = <?= !empty($place['longitude']) ? $place['longitude'] : 110.4091 ?>;

const map = L.map('map').setView([defaultLat, defaultLng], 15);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

let marker = L.marker([defaultLat, defaultLng]).addTo(map);

map.on('click', function(e){

    marker.setLatLng(e.latlng);

    document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
    document.getElementById('longitude').value = e.latlng.lng.toFixed(6);

});

</script>

</body>
</html>