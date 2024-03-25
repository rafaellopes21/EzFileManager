<?php ?>
<div class="fixed-bottom d-flex justify-content-end align-items-end p-3 button-plus">
    <div class="dropdown">
        <button class="btn btn-primary" type="button" id="dropPlus" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-plus"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropPlus">
            <?= import('_layouts/contextual/options.php'); ?>
        </ul>
    </div>
</div>

<ul class="dropdown-menu context-menu" id="contextMenu">
    <?= import('_layouts/contextual/options.php'); ?>
</ul>