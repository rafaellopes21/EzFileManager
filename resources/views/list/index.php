<?php
if(!isset($listing) || empty($listing)){
    echo '<div class="alert alert-dark text-center" role="alert" style="font-size: 26px;"><i class="fa-solid fa-triangle-exclamation"></i> '.translate('server_empty_folder').'</div>';
} else {
    echo '<div class="container-fluid"><h5>'. translate('upload_listing') .' '.count($listing).' '. translate('upload_showing') .'.</h5>
<div class="row">';
    foreach ($listing as $k => $item){
        $itemPath = $item['info']['dirname']."\\".$item['info']['basename'];
        $currentPath = isset($_GET['dir_path']) ? $_GET['dir_path']."/".$item['info']['basename'] : $item['info']['basename'];
        ?>

        <div class="card archive-card col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl-2 mb-1 position-relative bg-theme">
            <div class="position-absolute archive-menu btn dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis-vertical"></i>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item openLinkClick" type="button" <?= $item['type'] == "folder" ? "" : "hidden" ?>
                           onclick="loadLink(this)" to="/?dir_path=<?= urlencode($currentPath) ?>">
                            <i class="fa-regular fa-folder-open"></i> <?= translate('upload_open') ?>
                        </a>
                    </li>
                    <li><hr class="mt-1 mb-1"></li>
                    <li>
                        <a class="dropdown-item" type="button" onclick="renameContent('<?= $currentPath ?>', '<?= $item['info']['basename'] ?>')">
                            <i class="fa-solid fa-pen"></i> <?= translate('upload_rename') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" type="button" onclick="copyContent('<?= $currentPath ?>')">
                            <i class="fa-solid fa-copy"></i> <?= translate('upload_copy') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" type="button" onclick="moveContent('<?= $currentPath ?>')">
                            <i class="fa-solid fa-folder-tree"></i> <?= translate('upload_move') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" type="button" onclick="this.closest('.archive-card').querySelector('.downloadLinkClick').click();">
                            <i class="fa-solid fa-download"></i> <?= translate('upload_download') ?>
                        </a>
                    </li>
                    <li><hr class="mt-1 mb-1"></li>
                    <li class="deletion">
                        <a class="dropdown-item" type="button" onclick="deleteContent('<?= $currentPath ?>')">
                            <i class="fa-solid fa-trash-can"></i> <?= translate('upload_delete') ?>
                        </a>
                    </li>
                </ul>
            </div>
           <div class="archive-link" onclick="openClickLink(this)">
               <div class="icon">
                   <?php if($item['type'] == "folder"){
                       echo ' <i class="'.getSystemIcon().' fiv-icon-folder"></i>';
                   } else {
                       echo '<i class="'.getSystemIcon().' fiv-icon-'.$item['info']['extension'].'"></i>';
                   }?>
               </div>
               <div class="archive-title mt-1"><?= $item['info']['basename'] ?></div>
           </div>
           <a hidden class="downloadLinkClick" download="<?= $item['info']['basename'] ?>"
               href="/api/download?download_path=<?= $currentPath ?>"></a>
            <div class="archive-details">
                <div class="row">
                    <div class="col-4 text-start"><small><?= $item['info']['size_formated'] ?></small></div>
                    <div class="col-8 text-end">
                        <small class="dropdown-toggle" data-bs-toggle="collapse" href="#details-show-<?= $k ?>" role="button"
                               aria-expanded="false" aria-controls="details-show-<?= $k ?>">
                            <?= translate('upload_details') ?>
                        </small>
                    </div>
                </div>
                <div class="collapse mt-1" id="details-show-<?= $k ?>">
                    <div class="card">
                        <ul class="list-group detailing-archive">
                            <li class="list-group-item"><?= str_replace(str_replace("/", "\\", $replacerDirName)."\\", "", $itemPath); ?></li>
                            <li class="list-group-item"><b><?= translate('upload_detail_created') ?></b> <?= date("y-m-d H:i", strtotime($item['info']['created_at'])) ?></li>
                            <li class="list-group-item"><b><?= translate('upload_detail_modified') ?></b> <?= date("y-m-d H:i", strtotime($item['info']['modified_at'])) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
<?php }
    echo '</div></div>';
}?>