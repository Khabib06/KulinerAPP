<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Pembayaran Promosi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>">
    </script>

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-warning text-dark">

                    <h3 class="mb-0">
                        ⭐ Promosikan Tempat Kuliner
                    </h3>

                </div>

                <div class="card-body">

                    <h4><?= esc($place['nama_tempat']) ?></h4>

                    <hr>

                    <table class="table">

                        <tr>
                            <th>Paket</th>
                            <td>Premium</td>
                        </tr>

                        <tr>
                            <th>Durasi</th>
                            <td>30 Hari</td>
                        </tr>

                        <tr>
                            <th>Harga</th>
                            <td><b>Rp30.000</b></td>
                        </tr>

                        <tr>
                            <th>Benefit</th>
                            <td>
                                ✔ Muncul paling atas<br>
                                ✔ Badge PROMOTED<br>
                                ✔ Promosi aktif selama 30 hari
                            </td>
                        </tr>

                    </table>

                    <button
                        id="pay-button"
                        class="btn btn-success btn-lg w-100">

                        Bayar Sekarang

                    </button>

                    <a href="<?= base_url('/') ?>"
                       class="btn btn-secondary w-100 mt-2">

                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

document.getElementById('pay-button').onclick=function(){

    snap.pay('<?= $snapToken ?>',{

        onSuccess:function(result){

            fetch("<?= base_url('payment/success') ?>",{

                method:"POST",

                headers:{
                    "Content-Type":"application/json"
                },

                body:JSON.stringify(result)

            })

            .then(res=>res.json())

            .then(data=>{

                if(data.status=="success"){

                    alert("Pembayaran berhasil!");

                    window.location.href="<?= base_url('/') ?>";

                }else{

                    alert("Gagal update database");

                }

            });

        },

        onPending:function(){

            alert("Menunggu pembayaran");

        },

        onError:function(){

            alert("Pembayaran gagal");

        },

        onClose:function(){

            alert("Popup ditutup");

        }

    });

}

</script>

</body>
</html>