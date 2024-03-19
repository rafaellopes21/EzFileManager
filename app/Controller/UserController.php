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
            'users' => $this->getUsersList(),
        ]);
    }

    public function list(){
        return $this->view('user/user_list', [
            'users' => $this->getUsersList(),
        ]);
    }

    public function getUsersList(){
        $cols = "u.*, s.id as settings_id, s.storage_limit, s.expire_date";
        return self::user()['id'] == self::ADMIN
            ? Database::query("SELECT $cols FROM users as u left JOIN settings as s ON u.id = s.user_id")->get()
            : [];
    }

    public function update(){
        $data = $this->getData();
        $data['refreshing'] = false;

        $storageLimit = $data['storage_limit'];
        $expireDate = $data['expire_date'];
        $password = md5($data['password']);

        if(isset($data['delete']) && $data['delete'] == 1){
            Database::query("DELETE FROM users WHERE id = '".$data['id']."'");
            Database::query("DELETE FROM settings WHERE user_id = '".$data['id']."'");
            $data['refreshing'] = true;
            return $this->toJson($data, self::MSG_SUCCESS, translate('user_server_user_deleted'));
        }

        if(isset($data['edit'])){
            Database::query("UPDATE users SET user = '".strtolower($data['user'])."', password = '".$password."' WHERE id = '".$data['id']."'");
            if(Database::query("SELECT * FROM settings WHERE user_id = '".$data['id']."'")->count() == 0){
                Database::query("INSERT INTO settings (user_id, storage_limit, expire_date) VALUES ('".$data['id']."', '".$storageLimit."', '".$expireDate."')");
            } else {
                Database::query("UPDATE settings SET storage_limit = '".$storageLimit."', expire_date = '".$expireDate."' WHERE user_id = '".$data['id']."'");
            }
        } else {
            if($data['id'] == self::ADMIN){
                if(Database::query("SELECT * FROM users WHERE user = '".strtolower($data['user'])."'")->count() > 0){
                    return $this->toJson($data, self::MSG_WARNING, translate('user_server_user_duplicated'));
                }

                Database::query("INSERT INTO users (user, password) VALUES ('".strtolower($data['user'])."', '".$password."')");

                $nextId = Database::query("SELECT MAX(id) as id FROM users")->first();
                $nextId = $nextId['id'];
                Database::query("INSERT INTO settings (user_id, storage_limit, expire_date) VALUES ('".$nextId."', '".$storageLimit."', '".$expireDate."')");

                $data['refreshing'] = true;
                return $this->toJson($data, self::MSG_SUCCESS, translate('user_server_user_created'));
            }
        }

        return $this->toJson($data, self::MSG_SUCCESS, translate('user_server_user_updated'));
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