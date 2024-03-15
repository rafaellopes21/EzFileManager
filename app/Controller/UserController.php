<?php

namespace App\Controller;

class UserController extends Controller {

    public function __construct(){
        if(!enableFeature()){ $this->redirect('/', self::MSG_WARNING, translate('server_redirect_feature')); }
    }

    public function index(){
        return $this->view('user/index', ['title' => translate('sidebar_user')]);
    }
}