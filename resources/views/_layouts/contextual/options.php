<?php ?>
<form action="/api/upload" method="post">
    <input type="file" id="files" name="files[]" hidden multiple onchange="validateUpload('upload')">
    <input id="typeUpload" name="type" hidden>
    <input id="filepath" name="filepath" hidden value="<?= isset($_GET['dir_path']) ? $_GET['dir_path'] : '' ?>">

    <li onclick="document.querySelector('#files').click()">
        <a class="dropdown-item" type="button">
            <i class="fa-solid fa-upload fa-fw"></i> <?= translate("form_upload") ?>
        </a>
    </li>
    <hr class="mb-2 mt-2">
    <li onclick="openModal('/form/upload-file', false, true, this)">
        <a class="dropdown-item" type="button">
            <i class="fa-solid fa-file-circle-plus fa-fw"></i> <?= translate("form_new_file") ?>
        </a>
    </li>
    <li onclick="openModal('/form/upload-folder', false, true, this)">
        <a class="dropdown-item" type="button">
            <i class="fa-solid fa-folder-plus fa-fw"></i> <?= translate("form_new_folder") ?>
        </a>
    </li>
</form>