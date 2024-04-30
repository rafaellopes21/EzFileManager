<?php ?>
<form class="form-validator">
    <div class="col-12">
        <h5 class="mb-0"><b><?= translate($ruleList == "copy" ? 'upload_copying' : 'upload_moving').": " ?></b> <?= $current ?></h5>
        <hr class="mb-3 mt-1">
    </div>
</form>

<?php
if(!isset($listing) || empty($listing)){
    echo '<div class="alert alert-dark text-center" role="alert" style="font-size: 26px;"><i class="fa-solid fa-triangle-exclamation"></i> '.translate('server_nothing_found').'</div>';
} else {
    echo '<div class="card col-12"><ul class="list-group list-group-flush">';
    $lastBasePath = "";
    $paddingFolder = 0;

    foreach ($listing as $key => $item){
        $to = $item['dirname']."\\".$item['basename'];
        if(isset(pathinfo($current)['extension'])){
            $to .= "\\".pathinfo($current)['basename'];
        }

        $currentPath = isset($_GET['dir_path']) ? $_GET['dir_path']."/".$item['basename'] : $item['basename'];
        if($lastBasePath != $item['dirname'] && !isset($item['main_folder'])){
            $lastBasePath = $item['dirname'];
            $paddingFolder += 12;
        }?>

        <li class="list-group-item list-group-item-action folder-selection"
            onclick="validateCopyMove('<?= urlencode($current) ?>', '<?= urlencode($to) ?>', '<?= $ruleList ?>')"
            style="padding-left: <?= $paddingFolder == 0 ? "7" : $paddingFolder ?>px">
            <?= $paddingFolder > 0 ? '<i class="fa-solid fa-arrow-turn-up me-1" style="rotate: 90deg;"></i> ' : '' ?>
            <i class="fa-solid fa-folder-open"></i> <?= isset($item['main_folder']) ? translate('upload_main_dir') : $item['basename'] ?>
            <div class="text-muted dir_detail"><?= $item['dirname'] ?></div>
        </li>
    <?php }
    echo '</ul></div>';
}?>
