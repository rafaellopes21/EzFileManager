<?php

namespace App\Controller;

use AmplieSolucoes\EzFile\EzFile;
use App\helpers\Database;

class ManagerController extends Controller {

    private $user;
    public function __construct(){
        $u = UserController::user();
        $this->user = $u ? $u : ['id' => 1];
        EzFile::create(self::STORAGE_PATH."/".$this->user['id'], false, true);
    }

    public function index(){
        getStorageUsage($this->user['id']);
        return $this->view('home/index', ['title' => 'Hello World']);
    }

    public function upload(){
        $data = $this->getData();
        try {
            //paranm is: files[]
            if($this->updateStorageUsage($this->calculateFilesSize())){
                //Upload logic here
                var_dump("UPLOADING...");
            } else {
                return $this->toJson($this->getData(), self::MSG_WARNING, translate('server_storage_limit'));
            }

        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function refresh(){
        try {
            $data = $this->updateStorageUsage(false, $this->user['id']);
            if($data){
                return $this->toJson(['error' => false, 'response' => getStorageUsage($this->user['id'])], self::MSG_SUCCESS, translate('server_storage_updated'));
            } else {
                return $this->toJson(['error' => true, 'response' => []], self::MSG_SUCCESS, translate('server_default_error'));
            }
        } catch (\Exception $exception){
            return $this->toJson(['error' => true, 'response' => []], self::MSG_DANGER, $exception->getMessage());
        }
    }

    private function updateStorageUsage($usageSize, $refreshFolder = false){
        if(!Database::isEnabled()){
            return true;
        }

        $limit = "Unlimited";
        $usr = $this->user;

        if(!$refreshFolder){
            $storage = Database::query("SELECT storage_usage, storage_limit FROM settings WHERE user_id = '".$usr['id']."'")->first();

            if($storage['storage_limit'] != "Unlimited"){
                $split = explode(" ", $storage['storage_limit']);
                $limit = (int)explode(" ", EzFile::sizeUnitFormatter($split[0], $split[1], true))[0];
            }

            $split = explode(" ", $storage['storage_usage']);
            $usage = (int)explode(" ", EzFile::sizeUnitFormatter($split[0], $split[1], true))[0];
            $usage += $usageSize;
            $updateUsage = EzFile::sizeUnitFormatter($usage);
        } else {
            $usage = EzFile::pathInfo(self::STORAGE_PATH."/".$usr['id'], true);
            $usage = $usage['size_raw'];
            $updateUsage = EzFile::sizeUnitFormatter($usage);
        }

        $updateData = false;
        if($limit == "Unlimited" || $usage < $limit){
            $updateData = true;
        }

        if($updateData){
            Database::query("UPDATE settings SET storage_usage = '".$updateUsage."' WHERE user_id = '".$usr['id']."'");
            return true;
        } else {
            return false;
        }
    }

    private function calculateFilesSize(){
        $sumSize = 0;
        if(isset($_FILES['files']) && !empty($_FILES['files']['name'])){
            foreach ($_FILES['files']['name'] as $key => $file){
                $sumSize += $_FILES['files']['size'][$key];
            }
        }
        return $sumSize;
    }
}