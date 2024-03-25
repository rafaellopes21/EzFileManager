<?php
if(!isset($listing) || empty($listing)){
    echo '<div class="alert alert-dark text-center" role="alert" style="font-size: 26px;"><i class="fa-solid fa-triangle-exclamation"></i> '.translate('server_empty_folder').'</div>';
} else {
    foreach ($listing as $item){
        $itemPath = $item['info']['dirname']."\\".$item['info']['basename'];
        if($item['type'] === 'folder'){?>
            <h5><b>Nome:</b> <?= $item['info']['basename'] ?>, <b>Caminho Absoluto:</b> <?= $itemPath ?></h5>
        <?php } else {?>
            <h5><b>Nome:</b> <?= $item['info']['basename'] ?>, <b>Caminho Absoluto:</b> <?= $itemPath ?></h5>
        <?php }?>
<?php }
}?>