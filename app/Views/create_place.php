<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tempat Kuliner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body style="min-height:100vh; display:flex; flex-direction:column;">

<?= view('layout/navbar'); ?>

<div class="container mt-5" style="flex:1;">

    <h1 class="mb-4">Tambah Tempat Kuliner</h1>

    <form action="/place/store" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama Tempat</label>
            <input type="text" name="nama_tempat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control">

                <?php foreach ($categories as $category): ?>

                    <option value="<?= $category['id']; ?>">
                        <?= $category['nama_kategori']; ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </div>

        <!-- <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required></textarea>
        </div> -->

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label>Foto Tempat</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Lokasi di Peta</label>
            <div id="map" style="height:400px; border-radius:10px;"></div>
        </div>

        <div class="mt-3">

    <label class="form-label">
        📍 Alamat Lokasi
    </label>

    <textarea
        id="alamat"
        name="alamat"
        class="form-control"
        rows="3"
        readonly
        placeholder="Klik lokasi pada peta..."
        required></textarea>

</div>

<input
type="hidden"
id="latitude"
name="latitude">

<input
type="hidden"
id="longitude"
name="longitude">

        <br>
        <hr>

<!-- <h5>Promosi Tempat (Opsional)</h5>

<div class="form-check mb-3">
    <input
        class="form-check-input"
        type="checkbox"
        id="is_promoted"
        name="is_promoted"
        value="1">

    <label class="form-check-label" for="is_promoted">
        Saya ingin mempromosikan tempat ini
    </label>

    <small class="d-block text-muted">
        Tempat yang dipromosikan akan tampil di bagian paling atas halaman utama.
    </small>
</div> -->

<!-- <div id="promotion-section" style="display:none;">

    <label class="mb-2">
        Pilih Paket Promosi
    </label>

    <div class="form-check">

        <input
            class="form-check-input"
            type="radio"
            name="promotion_package"
            value="basic"
            data-price="10000">

        <label class="form-check-label">
            Basic - 7 Hari (Rp10.000)
        </label>

    </div>

    <div class="form-check">

        <input
            class="form-check-input"
            type="radio"
            name="promotion_package"
            value="premium"
            data-price="30000">

        <label class="form-check-label">
            Premium - 30 Hari (Rp30.000)
        </label>

    </div>

</div> -->

<input type="hidden"
       name="promotion_price"
       id="promotion_price"
       value="0">
        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

    </form>

</div>

<?= view('layout/footer'); ?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

const map = L.map('map').setView([-6.9825,110.4091],15);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'© OpenStreetMap'
}).addTo(map);

let marker=null;

map.on('click',function(e){

    const lat=e.latlng.lat.toFixed(6);
    const lng=e.latlng.lng.toFixed(6);

    document.getElementById("latitude").value=lat;
    document.getElementById("longitude").value=lng;

    if(marker){
        marker.setLatLng(e.latlng);
    }else{
        marker=L.marker(e.latlng).addTo(map);
    }

    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)

    .then(res=>res.json())

    .then(data=>{

        document.getElementById("alamat").value=data.display_name;

        marker.bindPopup(`
            <b>Lokasi Dipilih</b><br>
            ${data.display_name}
        `).openPopup();

    })

    .catch(()=>{

        document.getElementById("alamat").value=
        "Alamat tidak ditemukan";

    });

});
const promoCheck = document.getElementById('is_promoted');
const promoSection = document.getElementById('promotion-section');
const priceInput = document.getElementById('promotion_price');

promoCheck.addEventListener('change',function(){

    promoSection.style.display=this.checked
        ? 'block'
        : 'none';

    if(!this.checked){

        priceInput.value=0;

        document.querySelectorAll(
            'input[name="promotion_package"]'
        ).forEach(function(r){

            r.checked=false;

        });

    }

});

document
.querySelectorAll('input[name="promotion_package"]')
.forEach(function(radio){

    radio.addEventListener('change',function(){

        priceInput.value=this.dataset.price;

    });

});
</script>

</body>
</html>