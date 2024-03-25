<?php
if(!isset($listing) || empty($listing)){
    echo '<div class="alert alert-dark text-center" role="alert" style="font-size: 26px;"><i class="fa-solid fa-triangle-exclamation"></i> '.translate('server_empty_folder').'</div>';
} else {
    foreach ($listing as $item){ ?>
        <h5><?= $item ?></h5>
<?php }
}?>