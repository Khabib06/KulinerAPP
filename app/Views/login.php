<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Kuliner Kampus UDINUS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        body{

            background: #fff;

            min-height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

        }

        .login-card{

            border:none;

            border-radius:25px;

            overflow:hidden;

            box-shadow:0 20px 45px rgba(0,0,0,.25);

        }

        .left-side{

            background:#0a1f44;

            color:white;

            padding:50px;

            display:flex;

            flex-direction:column;

            justify-content:center;

        }

        .left-side h1{

            font-weight:700;

            margin-bottom:15px;

        }

        .left-side p{

            color:#ddd;

        }

        .right-side{

            background:#F6F1E9;

            padding:45px;

        }

        .form-control{

            border-radius:12px;

            padding:12px;

            border:1px solid #ddd;

        }

        .form-control:focus{

            border-color:#D4A66A;

            box-shadow:none;

        }

        .btn-login{

            background:#0a1f44;

            color:#ffff;

            border:none;

            border-radius:12px;

            padding:12px;

            font-weight:600;

        }

        .btn-login:hover{

            background:#c89555;

            color:#183A2A;

        }

        .btn-home{

            border-radius:12px;

        }

        .logo{

            font-size:65px;

            margin-bottom:20px;

        }

    </style>

</head>

<body>

<?php if(session()->getFlashdata('success')): ?>

<div class="position-absolute top-0 start-50 translate-middle-x mt-3" style="z-index:999">

    <div class="alert alert-success shadow">

        <?= session()->getFlashdata('success') ?>

    </div>

</div>

<?php endif; ?>

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-9">

<div class="card login-card">

<div class="row g-0">

<div class="col-md-5 left-side">

<div class="logo">
🍜
</div>

<h1>Kuliner Kampus</h1>

<p>

Temukan tempat kuliner terbaik di sekitar kampus UDINUS.

Promosikan usahamu, bagikan review, dan jelajahi kuliner favoritmu.

</p>

</div>

<div class="col-md-7 right-side">

<h2 class="fw-bold mb-4">

Login

</h2>

<form action="/process-login" method="post">

<div class="mb-3">

<label class="form-label">

<i class="bi bi-envelope-fill"></i>

Email

</label>

<input
type="email"
name="email"
class="form-control"
placeholder="Masukkan email">

</div>

<div class="mb-4">

<label class="form-label">

<i class="bi bi-lock-fill"></i>

Password

</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Masukkan password">

</div>

<button
class="btn btn-login w-100">

Masuk

</button>

<a
href="/"
class="btn btn-outline-dark w-100 mt-3 btn-home">

← Kembali ke Home

</a>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>