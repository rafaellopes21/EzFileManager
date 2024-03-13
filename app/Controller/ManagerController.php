<?php

namespace App\Controller;

class ManagerController extends Controller {

    public function index(){
        return $this->view('home/index', ['title' => 'Hello World']);
    }

    public function languages(){
        return $this->view('languages/index', ['title' => translate("sidebar_languages")]);
    }

    public function langChanger(){
        $data = $this->getData();
        unset($_SESSION['SYS_LANG']);
        unset($_SESSION['SYS_LANG_NAME']);
        $translated = self::setSystemLanguage($data['language']);
        $_SESSION['SYS_LANG'] = $translated['translation'];
        $_SESSION['SYS_LANG_NAME'] = $translated['lang'];
        $this->toJson($data, self::MSG_SUCCESS);
    }
}