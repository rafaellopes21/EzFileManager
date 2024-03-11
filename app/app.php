<?php
include 'routes/router.php';

function import($view, $viewData = []){
    return \App\Controller\Controller::render($view, $viewData);
}
