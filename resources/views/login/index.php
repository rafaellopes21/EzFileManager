<?php ?>
<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EzFileManager</title>
    <link rel="icon" type="image/x-icon" href="assets/images/icon.png">
    <link href="assets/libs/boostrap/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6ac77c14e0.js" crossorigin="anonymous"></script>
    <style>
        body, html {
            height: 100%;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .logo {
            max-width: 220px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-body-tertiary">

<div class="container p-2">
    <img src="assets/images/ez-filemanager-dark-logo.png" class="logo img-fluid">
    <div class="row justify-content-center">
        <h2 class="mb-2 text-center"><i class="fa-solid fa-key"></i> <?= translate('login_login') ?></h2>
        <hr>
        <form class="col-12" method="post" action="">
            <?php
            if(isset($_GET['error']) && $_GET['error']){
                echo '<div class="alert alert-danger text-center" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> '.$_GET['error'].'</div><hr>';
            }
            ?>
            <div class="mb-3">
                <label for="username" class="form-label"><?= translate('login_username') ?></label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><?= translate('login_password') ?></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-check"></i> <?= translate('login_login') ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="assets/libs/boostrap/popper.min.js"></script>
<script src="assets/libs/boostrap/bootstrap.min.js"></script>
</body>
</html>