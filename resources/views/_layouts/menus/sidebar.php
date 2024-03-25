<?php
$storageUsage = \App\Controller\UserController::user();
$storageUsage = getStorageUsage(isset($storageUsage['id']) ? $storageUsage['id'] : 0);
?>
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
    <div class="mb-2">
        <p class="mb-1" style="font-size: 14px">
            <span><?= $storageUsage['detail']; ?></span>
            <i class="fa-solid fa-arrows-rotate btn" id="btn-updt-stg" onclick="updateStorage(this)" style="font-size: 12px;"></i>
        </p>
        <div class="progress storage_bar_update" role="progressbar" aria-valuenow="<?= $storageUsage['percent']; ?>"
             aria-valuemin="0" title="<?= $storageUsage['percent']; ?>%" aria-valuemax="100" style="height: 5px">
            <div class="progress-bar <?= $storageUsage['class']; ?>" style="width: <?= $storageUsage['percent']; ?>%"></div>
        </div>
    </div>
    <div class="d-flex" style="margin: 0 auto">
        <a class="mt-1 mb-0 text-decoration-none" href="https://github.com/rafaellopes21/EzFileManager" target="_blank" style="color: initial">
            <i class="fa-solid fa-book me-2"></i> OpenSource FileManager
        </a>
    </div>
</div>
