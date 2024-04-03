<?php
if(!isset($listing) || empty($listing)){
    echo '<div class="alert alert-dark text-center" role="alert" style="font-size: 26px;"><i class="fa-solid fa-triangle-exclamation"></i> '.translate('server_empty_folder').'</div>';
} else {
    echo '<div class="row">';
    foreach ($listing as $item){
        $itemPath = $item['info']['dirname']."\\".$item['info']['basename'];
        $currentPath = isset($_GET['dir_path']) ? $_GET['dir_path']."/".$item['info']['basename'] : $item['info']['basename'];
        ?>
        <div class="card col-sm-12 col-md-6 col-lg-4 mb-3">
            <h4><?= $item['type'] ?></h4>
            <div class="card-body">
                <h5 class="card-title"><?= $item['info']['basename'] ?></h5>
                <p class="card-text"><?= $itemPath ?></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item list-group-item-action" <?= $item['type'] == "folder" ? "" : "hidden" ?>
                    onclick="loadLink(this)" to="/?dir_path=<?= urlencode($currentPath) ?>">
                    <?= translate('upload_open') ?>
                </li>
                <li class="list-group-item list-group-item-action" onclick="deleteContent('<?= $currentPath ?>')">
                    <?= translate('upload_delete') ?>
                </li>
                <li class="list-group-item list-group-item-action" onclick="renameContent('<?= $currentPath ?>', '<?= $item['info']['basename'] ?>')">
                    <?= translate('upload_rename') ?>
                </li>
                <li class="list-group-item list-group-item-action" onclick="copyContent('<?= $currentPath ?>')">
                    <?= translate('upload_copy') ?>
                </li>
                <li class="list-group-item list-group-item-action">
                    <?= translate('upload_move') ?>
                </li>
                <li class="list-group-item list-group-item-action">
                    <a download="<?= $item['info']['basename'] ?>" href="/api/download?download_path=<?= $currentPath ?>">
                        <?= translate('upload_download') ?>
                    </a>
                </li>
            </ul>
        </div>
<?php }
    echo '</div>';
}?>

