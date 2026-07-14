<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body style="min-height:100vh; display:flex; flex-direction:column;">

<?= view('layout/navbar'); ?>

<div class="container mt-5" style="flex:1;">

    <h1 class="mb-4">Dashboard Admin</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row g-3">

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Tempat</h5>
                <h2><?= $total_place; ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Review</h5>
                <h2><?= $total_review; ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>User</h5>
                <h2><?= $total_user; ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Pending</h5>
                <h2><?= $pending_place; ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3 shadow-sm">
                <h5>Pendapatan</h5>
                <h2>Rp<?= number_format($total_income,0,',','.'); ?></h2>
            </div>
        </div>

    </div>

    <div class="mt-4">

        <a href="/pending-places" class="btn btn-warning">
            Pending Places
        </a>

        <a href="/" class="btn btn-primary">
            Homepage
        </a>

        <a href="/logout" class="btn btn-danger">
            Logout
        </a>

    </div>

    <hr class="my-5">

    <h3 class="mb-3">Riwayat Pembayaran</h3>

    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>
                    <th>No</th>
                    <th>Order ID</th>
                    <th>Tempat</th>
                    <th>Paket</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th width="120">Aksi</th>
                </tr>

            </thead>

            <tbody>

            <?php if(empty($payments)): ?>

                <tr>
                    <td colspan="8" class="text-center">
                        Belum ada pembayaran
                    </td>
                </tr>

            <?php else: ?>

                <?php $no = 1; ?>

                <?php foreach($payments as $payment): ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= esc($payment['order_id']) ?></td>

                    <td><?= esc($payment['nama_tempat']) ?></td>

                    <td><?= esc($payment['package_name']) ?></td>

                    <td>
                        Rp<?= number_format($payment['amount'],0,',','.') ?>
                    </td>

                    <td>

                        <?php if($payment['status'] == 'paid'): ?>

                            <span class="badge bg-success">
                                Paid
                            </span>

                        <?php elseif($payment['status'] == 'pending'): ?>

                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                        <?php else: ?>

                            <span class="badge bg-danger">
                                Failed
                            </span>

                        <?php endif; ?>

                    </td>

                    <td>
                        <?= date('d-m-Y H:i', strtotime($payment['created_at'])) ?>
                    </td>

                    <td>

                        <?php if($payment['status'] == 'paid'): ?>

                            <button class="btn btn-secondary btn-sm" disabled>
                                Tidak Bisa
                            </button>

                        <?php else: ?>

                            <a href="<?= base_url('payment/delete/'.$payment['id']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus riwayat pembayaran ini?')">

                                Hapus

                            </a>

                        <?php endif; ?>

                    </td>

                </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?= view('layout/footer'); ?>

</body>
</html>