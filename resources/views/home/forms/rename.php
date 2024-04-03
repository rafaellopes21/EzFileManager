<?php ?>
<form class="form-validator">
    <div class="col-12 mb-1">
        <label><?= translate('upload_rename') ?></label>
        <input hidden id="currentRenameItem">
        <input class="form-control" id="concatRenameItem" aria-label=""
               placeholder="<?= translate('form_type_here') ?>" required oninput="validateRename(this, this)">
    </div>
</form>

<div class="alert alert-warning text-center alert-error-upload" hidden role="alert">
    <?= translate('upload_content_rename_error') ?>
</div>
