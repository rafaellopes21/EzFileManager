<?php
session_start();

function defaultLanguageTranslate(){
    return json_decode(file_get_contents(__DIR__."/languages/".strtolower("default.json")));
}

function translate($language_key = false){
    if($language_key){
        if(isset($_SESSION['SYS_LANG']->$language_key)){
            return $_SESSION['SYS_LANG']->$language_key;
        } else {
            return defaultLanguageTranslate()->$language_key;
        }
    } else {
        return $_SESSION['SYS_LANG'];
    }
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'routes/router.php';

function import($view, $viewData = []){
    return \App\Controller\Controller::render($view, $viewData);
}
