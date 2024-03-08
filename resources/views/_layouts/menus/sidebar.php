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
            <a class="nav-link active" href="#">
                <i class="fa-regular fa-user"></i>
                Profile
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="#" class="nav-link">
                <i class="fa-regular fa-newspaper"></i>
                Articles
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-archway"></i>
                Institutions
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-graduation-cap"></i>
                Organizations
            </a>
        </li>

        <li class="sidebar-item  nav-item mb-1">
            <a href="#" class="nav-link collapsed dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false" aria-controls="settings">
                <i class="fas fa-cog pe-2"></i>
                <span class="topic">Settings </span>
            </a>
            <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-sign-in-alt pe-2"></i>
                        <span class="topic"> Login</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-plus pe-2"></i>
                        <span class="topic">Register</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="nav-link">
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
        <span><h6 class="mt-1 mb-0">OpenSource FileManager</h6></span>
    </div>
</div>
