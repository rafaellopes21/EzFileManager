<?php

namespace App\Controller;

use App\helpers\Database;

class UserController extends Controller {

    public function __construct(){
        if(!enableFeature()){
            $this->redirect('/', self::MSG_WARNING, translate('server_redirect_feature'));
        }
    }

    public function index(){
        return $this->view('user/index', ['title' => translate('sidebar_user')]);
    }

    public function login(){
        $data = $this->getData();

        if(self::user()){ Controller::redirect("/"); }

        if(isset($data['username']) && isset($data['password'])){
            if($this->auth($data)){
                Controller::redirect("/");
            } else {
                Controller::redirect("/login?error=".translate('login_error_login') );
            }
        }

        \Flight::set('flight.views.path', __DIR__.'/../../resources/views');
        return \Flight::render('login/index', []);
    }

    public function logout(){
        unset($_SESSION['auth']);
        return Controller::redirect("/login");
    }

    private function auth($data){
        unset($_SESSION['auth']);
        $userExist = Database::query("SELECT * FROM users WHERE user = '".$data['username']."' AND password = '".md5($data['password'])."'")->first();
        if($userExist){
            $_SESSION['auth'] = $userExist;
            return true;
        } else {
            return false;
        }
    }

    public static function user(){
        return isset($_SESSION['auth'])
            ? Database::query("SELECT * FROM users WHERE id = '".$_SESSION['auth']['id']."'")->first()
            : false;
    }
}