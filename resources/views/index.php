<?php
?>

<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="assets/libs/boostrap/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6ac77c14e0.js" crossorigin="anonymous"></script>

    <title>EzFileManager</title>

    <style>
        html, body {
            height: 100%;
            font-family: 'Ubuntu', sans-serif;
        }

        .mynav li a {
            text-decoration: none;
            width: 100%;
            display: block;
            border-radius: 5px;
            padding: 8px 5px;
            color: initial;
        }

        .mynav li a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .mynav li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .mynav li a i {
            width: 25px;
            text-align: center;
        }
        #bdSidebar{
            max-width: 280px;;
        }
        .navbar-brand{
            margin: 0 auto;
        }
        .navbar-brand > img{
            max-width: 220px;
        }

    </style>
</head>
<body>

<div class="container-fluid p-0 d-flex h-100">
    <div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 offcanvas-lg offcanvas-start">
        <a href="#" class="navbar-brand"><img id="logo" src="assets/images/ez-filemanager-white-logo.png" class="img-fluid"></a>
        <hr>
        <ul class="mynav nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="#">
                    <i class="fa-regular fa-user"></i>
                    Profile
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="#">
                    <i class="fa-regular fa-newspaper"></i>
                    Articles
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="#">
                    <i class="fa-solid fa-archway"></i>
                    Institutions
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="#">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Organizations
                </a>
            </li>

            <li class="sidebar-item  nav-item mb-1">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false" aria-controls="settings">
                    <i class="fas fa-cog pe-2"></i>
                    <span class="topic">Settings </span>
                </a>
                <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="fas fa-sign-in-alt pe-2"></i>
                            <span class="topic"> Login</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="fas fa-user-plus pe-2"></i>
                            <span class="topic">Register</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="fas fa-sign-out-alt pe-2"></i>
                            <span class="topic">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <hr>
        <div class="d-flex">
            <i class="fa-solid fa-book me-2"></i>
            <span><h6 class="mt-1 mb-0">Geeks for Geeks Learning Portal</h6></span>
        </div>
    </div>

    <div class="flex-fill overflow-auto bg-body-tertiary">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-toggler" id="hamburguer-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                    <span class="navbar-toggler-icon"></span>
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="p-4">
            <nav style="--bs-breadcrumb-divider:'>';font-size:14px">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fa-solid fa-house"></i>
                    </li>
                    <li class="breadcrumb-item">Learning Content</li>
                    <li class="breadcrumb-item">Next Page</li>
                </ol>
            </nav>

            <hr>
            <div class="col">
                <button type="button" class="btn btn-outline-dark">Change/Dark Mode</button>
                <h1><?= $hello ?></h1>
                <hr>
                <?= import('_layouts/body'); ?>

                <p>Criar um jeito de intercalar o bootstrap entre modo dark e light</p>
                <p>criar template de projeto onde ficará o menu, sidebar e conteudo principal e obviamente o footer fixado eterno</p>

            </div>
        </div>
    </div>
</div>

<script src="assets/libs/boostrap/popper.min.js"></script>
<script src="assets/libs/boostrap/bootstrap.min.js"></script>
<script src="assets/libs/jquery/jquery-3.7.1.min.js"></script>
</body>
</html>