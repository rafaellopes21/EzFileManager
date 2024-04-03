<?php ?>
<form class="form-validator">
    <div class="col-12 mb-1">
        <label><?= translate('upload_content_file') ?></label>
        <input class="form-control" id="concatFilePath" aria-label=""
               placeholder="<?= translate('form_type_here') ?>" required oninput="isValidUpload(this)">
    </div>
</form>

<div class="alert alert-warning text-center alert-error-upload" hidden role="alert">
    <?= translate('upload_content_file_error') ?>
</div>
