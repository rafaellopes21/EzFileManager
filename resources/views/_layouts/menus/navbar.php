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
        <ul class="ms-auto profile-menu d-inline-flex">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" type="button" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-pic"><img src="assets/images/user.png"></div>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sliders-h fa-fw"></i> Exemplo 1</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-fw"></i> Exemplo 2</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <div class="dropdown dropstart">
                            <a class="dropdown-item" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation()">
                                <i class="fa-solid fa-globe fa-fw"></i>
                                <?= translate('navbar_language'); ?>
                                <b><?= strtoupper(substr((strtolower($_SESSION['SYS_LANG_NAME']) == "default" ? "english" : $_SESSION['SYS_LANG_NAME']), 0, 3)) ?></b>
                            </a>
                            <ul class="dropdown-menu overflow-y-auto" <?= count($languages) > 0 ? "" : "hidden" ?> style="max-height: 400px;top: -60px;">
                                <?php foreach ($languages as $l){
                                    if($l['file'] != "default"){
                                        echo '<li><a class="dropdown-item lang-selection" type="button" lang="'.$l['file'].'">'.$l['description'].'</a></li>';
                                    }
                                } ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item lang-selection" type="button" lang="default"><?= translate('navbar_language_default'); ?></a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item" type="button" id="theme-button">
                            <i class="fa-solid fa-sun fa-fw"></i> <span></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>