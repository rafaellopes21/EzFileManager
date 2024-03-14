<?php

namespace App\Controller;

use AmplieSolucoes\EzFile\EzFile;

class Controller{

    const MSG_WARNING = "text-bg-warning";
    const MSG_DANGER = "text-bg-danger";
    const MSG_SUCCESS = "text-bg-success";
    const MSG_INFO = "text-bg-info";
    const MSG_HELP = "text-bg-primary";
    const LANG_PATH = __DIR__."/../languages/";

    public static function setSystemLanguage($checkLang = false){
        if($checkLang == "default.json"){
            $checkLang = false;
        }

        if(isset($_SESSION['SYS_LANG']) && isset($_SESSION['SYS_LANG_NAME'])){
            $_SESSION['SYS_LANG'] = json_decode(file_get_contents(self::LANG_PATH.strtolower($_SESSION['SYS_LANG_NAME'].".json")));
        }

        if(!isset($_SESSION['SYS_LANG'])){
            $language = file_get_contents(self::LANG_PATH."default.json");
            if($checkLang && file_exists(self::LANG_PATH.$checkLang)){
                $language = file_get_contents(self::LANG_PATH.$checkLang);
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
            $dataContent['translation_default'] = str_replace('"', "'", json_encode(defaultLanguageTranslate()));
            $dataContent['languages'] = self::getCreatedLanguages();
            return self::render('index', $dataContent);
        }
    }

    public static function render($view, $viewData = []){
        \Flight::set('flight.views.path', __DIR__.'/../../resources/views');
        return \Flight::render($view, $viewData);
    }



    public static function getCreatedLanguages($onlyCreated = true){
        $currentLanguages = EzFile::list(self::LANG_PATH, true);

        for($x = 0; $x < count($currentLanguages); $x++){
            $lang = str_replace(self::LANG_PATH."/", "", $currentLanguages[$x]);
            $currentLanguages[$x] = explode(".", $lang)[0];
        }

        if($onlyCreated){
            $languagesCreated = [];
            foreach (getAllCountries() as $country){
                if(in_array($country['file'], $currentLanguages)){
                    $languagesCreated[] = $country;
                }
            }
            return $languagesCreated;
        } else {
            return $currentLanguages;
        }
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