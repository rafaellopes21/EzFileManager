<?php

namespace App\Controller;

use App\helpers\Database;

class UserController extends Controller {

    const ADMIN = 1;

    public function __construct(){
        if(!enableFeature()){
            $this->redirect('/', self::MSG_WARNING, translate('server_redirect_feature'));
        }
    }

    public function index(){
        return $this->view('user/index', [
            'title' => translate('sidebar_user'),
            'user' => self::user(),
        ]);
    }

    public function update(){
        $data = $this->getData();

        if(isset($data['edit'])){
            Database::query("UPDATE users SET (user, password) VALUES ('".strtolower($data['user'])."', '".md5($data['password'])."') WHERE id = '".$data['id']."'");
        } else {
            if($data['id'] == self::ADMIN){
                $hasUser = Database::query("SELECT id FROM users WHERE user = '".strtolower($data['user'])."'")->count();
                print_r($hasUser);die;
            }
        }

        return $this->toJson($data, self::MSG_SUCCESS);
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
        $userExist = Database::query("SELECT * FROM users WHERE user = '".strtolower($data['username'])."' AND password = '".md5($data['password'])."'")->first();
        if($userExist){
            $_SESSION['auth'] = $userExist;
            return true;
        } else {
            return false;
        }
    }

    public static function user(){
        if(!isset($_SESSION['auth'])){
            return false;
        }

        $cols = "u.*, s.id as settings_id, s.storage_limit, s.expire_date";
        return Database::query("SELECT $cols FROM users as u left JOIN settings as s ON u.id = s.user_id WHERE u.id = '".$_SESSION['auth']['id']."'")->first();
    }
}