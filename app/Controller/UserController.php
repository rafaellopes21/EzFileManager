<?php

namespace App\Controller;

use AmplieSolucoes\EzFile\EzFile;
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
        $cols = "u.*, s.id as settings_id, s.storage_usage, s.storage_limit, s.expire_date";
        return self::user()['id'] == self::ADMIN
            ? Database::query("SELECT $cols FROM users as u left JOIN settings as s ON u.id = s.user_id")->get()
            : [];
    }

    public function update(){
        try {
            $data = $this->getData();
            $data['refreshing'] = false;

            $msgReturn = translate('user_server_user_updated');
            $storageLimit = $data['id'] == self::ADMIN ? "Unlimited" : $data['storage_limit'];
            $expireDate = $data['id'] == self::ADMIN ? "9999-12-31" : $data['expire_date'];
            $password = !empty($data['password']) ? md5($data['password']) : Database::query("SELECT password FROM users WHERE id = '".$data['id']."'")->first()['password'];
            $usrImgId = $data['id'];
            unset($data['profile']);

            if(isset($data['delete']) && $data['delete'] == 1){
                if($data['id'] == self::ADMIN){
                    return $this->toJson($data, self::MSG_DANGER, translate('user_server_block_admin'));
                }

                Database::query("DELETE FROM users WHERE id = '".$data['id']."'");
                Database::query("DELETE FROM settings WHERE user_id = '".$data['id']."'");
                EzFile::delete(self::AVATAR_PATH."/".$usrImgId, true);
                $data['refreshing'] = true;
                return $this->toJson($data, self::MSG_SUCCESS, translate('user_server_user_deleted'));
            }

            if(isset($data['edit'])){
                Database::query("UPDATE users SET user = '".strtolower($data['user'])."', password = '".$password."' WHERE id = '".$data['id']."'");
                Database::query("UPDATE settings SET storage_limit = '".$storageLimit."', expire_date = '".$expireDate."' WHERE user_id = '".$data['id']."'");
            } else {
                if($data['id'] == self::ADMIN){
                    if(Database::query("SELECT * FROM users WHERE user = '".strtolower($data['user'])."'")->count() > 0){
                        return $this->toJson($data, self::MSG_WARNING, translate('user_server_user_duplicated'));
                    }

                    $nextId = Database::query("SELECT MAX(id) as id FROM users")->first();
                    $nextId = $nextId['id'] + 1;
                    $usrImgId = $nextId;
                    Database::query("INSERT INTO users (id, user, password) VALUES ('".$nextId."', '".strtolower($data['user'])."', '".$password."')");
                    Database::query("INSERT INTO settings (user_id, storage_usage, storage_limit, expire_date) VALUES ('".$nextId."', '0', '".$storageLimit."', '".$expireDate."')");

                    $data['refreshing'] = true;
                    $msgReturn = translate('user_server_user_created');
                }
            }

            if(isset($_FILES['profile']) && isset($_FILES['profile']['name']) && !empty($_FILES['profile']['name'])){
                EzFile::upload(self::AVATAR_PATH."/".$usrImgId, $_FILES, md5($_FILES['profile']['name']), [], true);
            }

            return $this->toJson($data, self::MSG_SUCCESS, $msgReturn);
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function login(){
        $data = $this->getData();

        if(self::user()){ Controller::redirect("/"); }

        if(isset($data['username']) && isset($data['password'])){
            if($userValidate = $this->validateUser($data)){
                $userValidate = Database::query("SELECT expire_date FROM settings WHERE user_id = '".$userValidate['id']."'")->first();

                if(isset($userValidate['expire_date']) && strtolower($userValidate['expire_date']) != "unlimited"){
                    if(date("Y-m-d") > $userValidate['expire_date']){
                        Controller::redirect("/login?error=".translate('login_expired')); die;
                    }
                }

                if($this->auth($data)){
                    Controller::redirect("/"); die;
                }
            }
            Controller::redirect("/login?error=".translate('login_error_login')); die;
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
        $userExist = $this->validateUser($data);
        if($userExist){
            $_SESSION['auth'] = $userExist;
            return true;
        } else {
            return false;
        }
    }

    private function validateUser($data){
        return Database::query("SELECT * FROM users WHERE user = '".strtolower($data['username'])."' AND password = '".md5($data['password'])."'")->first();
    }

    public static function user(){
        if(!isset($_SESSION['auth'])){
            return false;
        }

        $cols = "u.*, s.id as settings_id, s.storage_limit, s.expire_date";
        return Database::query("SELECT $cols FROM users as u left JOIN settings as s ON u.id = s.user_id WHERE u.id = '".$_SESSION['auth']['id']."'")->first();
    }
}