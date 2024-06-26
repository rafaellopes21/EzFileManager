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
                    <div class="profile-pic"><img src="<?= getAvatar() ?>" class="rounded-circle img-fluid"></div>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
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
                        <div class="dropdown dropstart">
                            <a class="dropdown-item" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                               onclick="event.stopPropagation()">
                                <i class="fa-solid fa-icons fa-fw"></i>
                                <?= translate('navbar_icon'); ?>
                            </a>
                            <ul class="dropdown-menu overflow-y-auto" style="max-height: 400px;top: -60px;">
                                <li>
                                    <a class="dropdown-item icon-selection<?= getSystemIcon() == "fiv-cla" ? " active" : "" ?>" type="button" icon="fiv-cla">
                                        <span class="fiv-cla fiv-icon-bat fa-fw"></span> <?= translate('navbar_icon_classic'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item icon-selection<?= getSystemIcon() == "fiv-viv" ? " active" : "" ?>" type="button" icon="fiv-viv">
                                        <span class="fiv-viv fiv-icon-bat fa-fw"></span> <?= translate('navbar_icon_vivid'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item icon-selection<?= getSystemIcon() == "fiv-sqo" ? " active" : "" ?>" type="button" icon="fiv-sqo">
                                        <span class="fiv-sqo fiv-icon-bat fa-fw"></span> <?= translate('navbar_icon_outline'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item" type="button" id="theme-button">
                            <i class="fa-solid fa-sun fa-fw"></i> <span></span>
                        </a>
                    </li>
                    <li <?= enableFeature('/logout', true); ?>><hr class="dropdown-divider"></li>
                    <li <?= enableFeature('/logout', true); ?> class="bg-danger">
                        <a class="dropdown-item text-white bg-danger" href="/logout">
                            <i class="fa-solid fa-right-from-bracket fa-fw"></i> <?= translate('navbar_logout'); ?>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>