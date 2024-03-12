<?php ?>
<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="assets/libs/boostrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/global.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6ac77c14e0.js" crossorigin="anonymous"></script>

    <title>EzFileManager</title>
</head>
<body>
    <div class="loading-content loader show-loader"></div>

    <div class="container-fluid p-0 d-flex h-100 blur-content" id="general-content">
        <?= import('_layouts/menus/navbar'); ?>
        <?= import('_layouts/menus/sidebar'); ?>
        <div class="flex-fill overflow-auto p-3 fix-header" id="main-content">
            <?= import($main_content); ?>
        </div>
    </div>


    <script src="assets/libs/boostrap/popper.min.js"></script>
    <script src="assets/libs/boostrap/bootstrap.min.js"></script>
    <script src="assets/libs/jquery/jquery-3.7.1.min.js"></script>
    <script src="assets/js/global.js"></script>
</body>
</html>