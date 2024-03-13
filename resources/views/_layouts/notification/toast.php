<?php ?>
<input hidden id="sys_lang" value="<?= $translation ?>">
<button type="button" id="notificationToastBtn" hidden></button>

<div hidden id="default_titles">
    <input id="default-text-bg-warning" value="<?= translate('notification_warning') ?>">
    <input id="default-text-bg-danger" value="<?= translate('notification_danger') ?>">
    <input id="default-text-bg-success" value="<?= translate('notification_success') ?>">
    <input id="default-text-bg-info" value="<?= translate('notification_info') ?>">
    <input id="default-text-bg-primary" value="<?= translate('notification_help') ?>">
</div>

<div class="toast-container position-fixed top-0 end-0 p-4">
    <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="8000">
        <div class="toast-header" style="border-bottom: 1px solid #8383838a;">
            <span class="me-2"></span>
            <strong class="me-auto" id="toast-title-txt"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" style="background: #b1b1b13d !important;"></div>
    </div>
</div>
