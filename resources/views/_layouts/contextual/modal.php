<?php ?>
<button id="btn_modal_open" type="button" data-bs-toggle="modal" data-bs-target="#globalModal" hidden></button>
<div class="modal fade" id="globalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modal_global_dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_global_modal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="body_global_modal"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_global_modal">
                    <i class="fa-solid fa-xmark"></i> <?= translate('form_close') ?>
                </button>
                <button type="button" class="btn btn-primary" id="save_global_modal_btn">
                    <i class="fa-solid fa-check"></i> <?= translate('form_submit') ?>
                </button>
            </div>
        </div>
    </div>
</div>