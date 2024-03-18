<?php ?>
<div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 offcanvas-lg offcanvas-start bg-light" style="border-right: 1px solid #e0e1e2;">
    <div class="mobile-only">
        <a type="button" class="navbar-brand center-brand">
            <img src="assets/images/ez-filemanager-dark-logo.png" class="img-fluid logo"
                 light="assets/images/ez-filemanager-white-logo.png"
                 dark="assets/images/ez-filemanager-dark-logo.png">
        </a>
        <a class="navbar-toggler" onclick="toggle_sidebar.click()" type="button" style="border: none;float: right;position: relative;top: 22px;right: 6px;font-size: 22px;">
            <i class="fa-solid fa-bars"></i>
        </a>
        <hr>
    </div>

    <ul class="mynav nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1">
            <a class="nav-link" type="button" to="/">
                <i class="fa-solid fa-house"></i> <?= translate('sidebar_home'); ?>
            </a>
        </li>
        <hr class="mb-2 mt-2">
        <li class="nav-item mb-1">
            <a class="nav-link" type="button">
                <i class="fa-solid fa-link"></i> Example 1
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" type="button">
                <i class="fa-solid fa-link"></i> Example 2
            </a>
        </li>
        <li class="sidebar-item nav-item mb-1">
            <a type="button" class="nav-link collapsed dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false" aria-controls="settings">
                <i class="fas fa-cog pe-2"></i>
                <span class="topic"><?= translate('sidebar_settings'); ?></span>
            </a>
            <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a class="nav-link" type="button" to="/languages">
                        <i class="fa-solid fa-language"></i> <?= translate('sidebar_languages'); ?>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="nav-link <?= enableFeature('/user'); ?>" type="button" to="/user">
                        <i class="fa-solid fa-user"></i> <?= translate('sidebar_user'); ?>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <hr>
    <div class="d-flex">
        <i class="fa-solid fa-book me-2"></i>
        <span><h6 class="mt-1 mb-0">OpenSource FileManager</h6></span>
    </div>
</div>
