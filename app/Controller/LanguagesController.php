<?php

namespace App\Controller;

use AmplieSolucoes\EzFile\EzFile;

class LanguagesController extends Controller {

    public function index(){
        return $this->view('languages/index', [
            'title' => translate("sidebar_languages"),
            'allLanguages' => getAllCountries(),
            'defaultLanguage' => defaultLanguageTranslate(),
            'currentLanguages' => self::getCreatedLanguages(false),
        ]);
    }

    public function change(){
        $data = $this->getData();
        unset($_SESSION['SYS_LANG']);
        unset($_SESSION['SYS_LANG_NAME']);
        $translated = self::setSystemLanguage($data['language']);
        $_SESSION['SYS_LANG'] = $translated['translation'];
        $_SESSION['SYS_LANG_NAME'] = $translated['lang'];

        return $this->toJson($data, self::MSG_SUCCESS);
    }

    public function pick(){
        $data = $this->getData();
        $dir = self::LANG_PATH.$data['lang'].".json";

        $content = [];
        if(EzFile::exists($dir, true)){
            $content = (array)defaultLanguageTranslate($data['lang']);
        }

        $msgType = empty($content) ? false : self::MSG_SUCCESS;
        $msgText = $msgType ? translate("languages_server_loaded") : false;

        return $this->toJson($content, $msgType, $msgText);
    }

    public function create(){
        try {
            $data = $this->getData();
            $languageName = $data['language_name'];
            $languageFile = self::LANG_PATH.$languageName.".json";
            $default = defaultLanguageTranslate();
            unset($data['language_name']);

            foreach ($data as $key => $translated){
                if(!$translated){
                    $data[$key] = $default->$key;
                }
            }

            $fileHandle = fopen($languageFile, 'w');
            if ($fileHandle === false) {
                return $this->toJson($this->getData(), self::MSG_DANGER, translate('languages_server_file_fail'));
            }

            fwrite($fileHandle, json_encode($data, JSON_PRETTY_PRINT));
            fclose($fileHandle);

            return $this->toJson(["new_lang" => $languageName], self::MSG_SUCCESS, translate("languages_server_file_create"));
        } catch (\Exception $exception){
            return $this->toJson([
                "data" => $this->getData(), "exception" => $exception->getMessage()
            ], self::MSG_DANGER, translate('server_default_error'));
        }
    }

    public function delete(){
        try {
            $data = $this->getData();
            $languageFile = self::LANG_PATH.$data['lang'].".json";

            if(EzFile::exists($languageFile, true)){
                EzFile::delete($languageFile, true);
            }

            return $this->toJson(["deleted" => $data['lang']], self::MSG_SUCCESS, translate("languages_server_file_delete"));
        } catch (\Exception $exception){
            return $this->toJson([
                "data" => $this->getData(), "exception" => $exception->getMessage()
            ], self::MSG_DANGER, translate('server_default_error'));
        }
    }
}