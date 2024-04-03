<?php ?>
<form class="form-validator">
    <div class="col-12 mb-1">
        <label><b><?= translate('upload_copying').": " ?></b><?= $current ?></label>
    </div>
</form>

<?php
if(!isset($listing) || empty($listing)){
    echo '<div class="alert alert-dark text-center" role="alert" style="font-size: 26px;"><i class="fa-solid fa-triangle-exclamation"></i> '.translate('server_nothing_found').'</div>';
} else {
    echo '<div class="card col-12 mb-3"><ul class="list-group list-group-flush">';
    foreach ($listing as $item){
        $itemPath = $item['info']['dirname']."\\".$item['info']['basename'];
        $currentPath = isset($_GET['dir_path']) ? $_GET['dir_path']."/".$item['info']['basename'] : $item['info']['basename'];
        ?>
        <li class="list-group-item list-group-item-action" onclick="validateCopy('<?= urlencode($current) ?>', '<?= urlencode($currentPath) ?>')"><?= $itemPath ?></li>
    <?php }
    echo '</ul></div>';
}?>
