<?php
session_start();

function translate($language_key = false){
    return $language_key && isset($_SESSION['SYS_LANG']->$language_key) ? $_SESSION['SYS_LANG']->$language_key : $_SESSION['SYS_LANG'];
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'routes/router.php';

function import($view, $viewData = []){
    return \App\Controller\Controller::render($view, $viewData);
}
