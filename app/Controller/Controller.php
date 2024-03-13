<?php

namespace App\Controller;

use AmplieSolucoes\EzFile\EzFile;

class Controller{

    const MSG_WARNING = "text-bg-warning";
    const MSG_DANGER = "text-bg-danger";
    const MSG_SUCCESS = "text-bg-success";
    const MSG_INFO = "text-bg-info";
    const MSG_HELP = "text-bg-primary";

    public static function setSystemLanguage($checkLang = false){
        if($checkLang == "default.json"){
            $checkLang = false;
        }

        $pathLang = __DIR__."/../languages/";

        if(isset($_SESSION['SYS_LANG']) && isset($_SESSION['SYS_LANG_NAME'])){
            $_SESSION['SYS_LANG'] = json_decode(file_get_contents($pathLang.strtolower($_SESSION['SYS_LANG_NAME'].".json")));
        }

        if(!isset($_SESSION['SYS_LANG'])){
            $language = file_get_contents($pathLang."default.json");
            if($checkLang && file_exists($pathLang.$checkLang)){
                $language = file_get_contents($pathLang.$checkLang);
            } else {
                unset($_SESSION['SYS_LANG_NAME']);
            }
            $_SESSION['SYS_LANG'] = json_decode($language);
        }
        if(!isset($_SESSION['SYS_LANG_NAME'])){
            $_SESSION['SYS_LANG_NAME'] = $checkLang ? explode(".", strtolower($checkLang))[0] : "default";
        }

        return ['lang' => $_SESSION['SYS_LANG_NAME'], 'translation' => $_SESSION['SYS_LANG']];
    }

    public static function view($view, $dataSecondView = []) {
        if(isset($_GET['instantLoad'])){
            unset($_GET['instantLoad']);
            return self::render($view, $dataSecondView);
        } else {
            self::setSystemLanguage();
            $dataContent = $dataSecondView;
            $dataContent['main_content'] = $view;
            $dataContent['translation'] = str_replace('"', "'", json_encode(translate()));
            $dataContent['languages'] = EzFile::list(__DIR__."/../languages/", true);
            sort($dataContent['languages']);
            return self::render('index', $dataContent);
        }
    }

    public static function render($view, $viewData = []){
        \Flight::set('flight.views.path', __DIR__.'/../../resources/views');
        return \Flight::render($view, $viewData);
    }

    public function getData(){
        $data = \Flight::request()->data->getData();
        if(!$data || empty($data)){ $data = []; }

        if(isset($_GET)){
            foreach ($_GET as $key => $val){
                if(!isset($data[$key])){
                    $data[$key] = $val;
                }
            }
        }

        return $data;
    }

    public function toJson(Array $arrayData, $typeMessage = self::MSG_SUCCESS, $message = false, $error = false){
        return \Flight::json([
            'error' => $error,
            'status' => $error ? 400 : 200,
            'response' => $arrayData,
            'message' => $message,
            'type' => $typeMessage,
        ]);
    }
}