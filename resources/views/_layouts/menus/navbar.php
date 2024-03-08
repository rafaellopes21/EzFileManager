<?php ?>

<nav id="main-navbar" class="navbar navbar-expand-lg fixed-top bg-light" style="border-bottom: 1px solid #e0e1e2;">
    <div class="container-fluid" style="justify-content: initial;">
        <a class="navbar-toggler" id="toggle_sidebar" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar" style="border: none">
            <i class="fa-solid fa-bars"></i>
        </a>
        <a class="navbar-brand ms-2" type="button">
            <img src="assets/images/ez-filemanager-dark-logo.png" class="img-fluid logo"
                 light="assets/images/ez-filemanager-white-logo.png"
                 dark="assets/images/ez-filemanager-dark-logo.png">
        </a>
        <ul class="ms-auto profile-menu">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" type="button" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-pic"><img src="assets/images/user.png"></div>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sliders-h fa-fw"></i> Account</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-fw"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" type="button" id="theme-button">
                            <i class="fa-solid fa-sun fa-fw"></i> <span>Theme Light</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
