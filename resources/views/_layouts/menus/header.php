<?php
    $breadcrumbs = [];
    $dirPathRoute = isset($_GET['dir_path']) ? $_GET['dir_path'] : $_SERVER['REQUEST_URI'];
    $breadName = isset($_GET['dir_path']) ? "home" : false;
    if($dirPathRoute !== "/"){
        $linkPages = $dirPathRoute;
        $linkPages = strpos($linkPages, "?") !== false ? explode("?", $linkPages)[0] : $linkPages;
        $breadcrumbs = explode("/", $linkPages);
        if(isset($breadcrumbs[0]) && isset($breadcrumbs[1])){
            $clear = true;
            foreach ($breadcrumbs as $breadcrumb){
                if($breadcrumb){ $clear = false; break; }
            }
            $breadcrumbs = $clear ? [] : $breadcrumbs;
        }
    }

    if(isset($title)){
       echo '<div class="mb-2 rounded-3 bg-theme"><h2 class="display-6 fw-bold p-3">'.$title.'</h2></div>';
    }
?>

<div style="--bs-breadcrumb-divider:'>';font-size:14px">
    <ol class="breadcrumb mb-2 ms-2">
        <?php
        $concatPathName = "";
        foreach ($breadcrumbs as $k => $breadcrumb){
            if(strlen($breadcrumb) > 0){
                if($breadName){
                    if($k == 0){
                        echo '<li class="breadcrumb-item" onclick="loadLink(this)" to="/"><i class="fa-solid fa-house"></i></li>';
                    }
                    $concatPathName .= "/".$breadcrumb;
                    echo '<li class="breadcrumb-item" onclick="loadLink(this)" to="/?dir_path='.urlencode($concatPathName).'">'.ucfirst($breadcrumb).'</li>';
                } else {
                    echo '<li class="breadcrumb-item" onclick="loadLink(this)" to="/'.$breadcrumb.'">'.ucfirst(translate('sidebar_'.$breadcrumb)).'</li>';
                }
            }
            if(!$breadcrumb && $k == 0){
                echo '<li class="breadcrumb-item" onclick="loadLink(this)" to="/"><i class="fa-solid fa-house"></i></li>';
            }
        }?>
    </ol>
</div>
<hr class="mt-2 mb-3">