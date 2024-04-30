<?php

namespace App\Controller;

use AmplieSolucoes\EzFile\EzFile;
use App\helpers\Database;

class ManagerController extends Controller {

    private $user;
    private $uploadFolder;
    public function __construct(){
        $u = UserController::user();
        $this->user = $u ? $u : ['id' => 1];
        $this->uploadFolder = self::STORAGE_PATH."/".$this->user['id'];
        EzFile::create($this->uploadFolder, false, true);
    }

    public function index(){
        getStorageUsage($this->user['id']);
        return $this->view('home/index', [
            'title' => translate('sidebar_home'),
            'listing' => $this->list(true),
            'replacerDirName' => $this->uploadFolder,
        ]);
    }

    public function list($listOnly = false, $getRootDir = false){
        /*
         PARAMNS:
            'dir_path': 'path_where_files_are_located_to_be_listed'
         */
        if(!$listOnly && !isset($_GET['instantLoad'])){
            return $this->redirect('/?'.$_SERVER['QUERY_STRING']);
        }

        $data = $this->getData();
        try {
            $pathList = isset($data['dir_path']) ? $this->getStoragePath($data['dir_path']) : $this->getStoragePath(self::STORAGE_PATH);
            if(!EzFile::exists($pathList)){ return []; }

            $ezFile = EzFile::list($pathList, true);

            $files = [];
            if($listOnly && $getRootDir){
                $files[] = [
                    "info" => EzFile::pathInfo($this->getStoragePath(self::STORAGE_PATH), true),
                    "type" => "folder",
                ];
            }
            if($ezFile && !empty($ezFile)){
                foreach ($ezFile as $item){
                    $info = EzFile::pathInfo($item, true);
                    $type = isset($info['extension']) ? "file" : "folder";
                    array_push($files, ["info" => $info, "type" => $type]);
                }
            }

            $fixPositions = [];
            foreach ($files as $file){
                if($file['type'] == 'folder'){
                    $fixPositions[] = $file;
                }
            }
            foreach ($files as $file){
                if($file['type'] != 'folder'){
                    $fixPositions[] = $file;
                }
            }

            $files = $fixPositions;

            return $listOnly ? $files : $this->view('home/index', [
                'title' => translate('sidebar_home'),
                'listing' => $files,
                'replacerDirName' => $this->uploadFolder,
            ]);
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function upload(){
        /*
         PARAMNS:
            'type': create / upload
            'filepath': 'name_of_file_or_folder_with_path: file.txt'
            'files[]': $_FILES
         */
        $data = $this->getData();
        try {
            $data['filepath'] = empty($data['filepath']) ? $this->uploadFolder : $this->getStoragePath($data['filepath']);

            if($data['type'] == "create"){
                $create = $data['filepath'];
                EzFile::create($create, false, true);
                return $this->toJson($this->refresh(true), self::MSG_SUCCESS, translate('server_storage_created'));
            }

            if($data['type'] == "upload"){
                if($this->updateStorageUsage($this->calculateFilesSize())){
                    $ezFile = EzFile::upload($data['filepath'], $_FILES, false, [], true);
                    if(isset($ezFile['error'])){
                        return $this->toJson($this->getData(), self::MSG_DANGER, translate('server_upload_error')." | ".$ezFile['message']);
                    }

                    return $this->toJson($this->refresh(true), self::MSG_SUCCESS, translate('server_storage_uploaded'));
                } else {
                    return $this->toJson($this->refresh(true), self::MSG_WARNING, translate('server_storage_limit'));
                }
            }

            return $this->toJson($this->getData(), self::MSG_DANGER, translate('server_default_error'));
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function delete(){
        /*
         PARAMNS:
            'filepath': 'name_of_file_or_folder_with_path: file.txt'
         */
        $data = $this->getData();
        try {
            $ezFile = EzFile::delete($this->getStoragePath($data['filepath']), true);
            if(isset($ezFile['error'])){
                return $this->toJson($this->getData(), self::MSG_DANGER, translate('server_delete_error')." | ".$ezFile['message']);
            } else {
                return $this->toJson($this->refresh(true), self::MSG_SUCCESS, translate('server_delete_success'));
            }
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function rename(){
        /*
         PARAMNS:
            'original_name': 'original_file_folder_path'
            'rename_to': 'original_file_folder_renamed'
         */
        $data = $this->getData();
        try {
            $original = $this->getStoragePath($data['original_name']);
            $renamed = $this->getStoragePath($data['rename_to']);

            $ezFile = EzFile::rename($original, $renamed, false, true);
            if(isset($ezFile['error'])){
                return $this->toJson($this->getData(), self::MSG_DANGER, translate('server_rename_error')." | ".$ezFile['message']);
            } else {
                return $this->toJson($this->refresh(true), self::MSG_SUCCESS, translate('server_rename_success'));
            }
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function copy(){
        /*
         PARAMNS:
            'copy_from': 'original_file_folder_path_to_copy'
            'copy_to': 'original_file_folder_to_paste'
         */
        $data = $this->getData();
        try {
            $from = $this->getStoragePath(urldecode($data['copy_from']));
            $to = str_replace("/", "\\", urldecode($data['copy_to']));

            $ezFile = EzFile::copy($from, $to, true);
            if(isset($ezFile['error'])){
                return $this->toJson($this->getData(), self::MSG_DANGER, translate('server_copy_error')." | ".$ezFile['message']);
            } else {
                return $this->toJson($this->refresh(true), self::MSG_SUCCESS, translate('server_copy_success'));
            }
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function move(){
        /*
         PARAMNS:
            'move_from': 'original_file_folder_path_to_move'
            'move_to': 'moving_file_folder'
         */
        $data = $this->getData();
        try {
            $from = $this->getStoragePath(urldecode($data['move_from']));
            $to = str_replace("/", "\\", urldecode($data['move_to']));

            $ezFile = EzFile::move($from, $to, true);
            if(isset($ezFile['error'])){
                return $this->toJson($this->getData(), self::MSG_DANGER, translate('server_move_error')." | ".$ezFile['message']);
            } else {
                return $this->toJson($this->refresh(true), self::MSG_SUCCESS, translate('server_move_success'));
            }
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function download(){
        /*
         PARAMNS:
            'download_path': 'original_file_folder_path_to_download'
         */
        $data = $this->getData();
        try {
            $ezFile = EzFile::download($this->getStoragePath($data['download_path']), true);

            if(isset($ezFile['error'])){
                return $this->toJson($this->getData(), self::MSG_DANGER, translate('server_download_error')." | ".$ezFile['message']);
            } else {
                return $this->toJson($this->getData(), self::MSG_SUCCESS, translate('server_download_success'));
            }
        } catch (\Exception $exception){
            return $this->toJson($this->getData(), self::MSG_DANGER, $exception->getMessage());
        }
    }

    public function refresh($fromServer = false){
        try {
            $data = $this->updateStorageUsage(false, $this->user['id']);
            if($data){
                if($fromServer){
                    return ['response' => getStorageUsage($this->user['id']), 'error' => false];
                } else {
                    return $this->toJson(['error' => false, 'response' => getStorageUsage($this->user['id'])], self::MSG_SUCCESS, translate('server_storage_updated'));
                }
            } else {
                if($fromServer){
                    return ['response' => [], 'error' => true];
                } else {
                    return $this->toJson(['error' => true, 'response' => []], self::MSG_SUCCESS, translate('server_default_error'));
                }
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
            $split[1] = isset($split[1]) ? $split[1] : EzFile::UNIT_GIGABYTES;
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

    public function getFolders(){
        $listing = $this->list(true, true);
        $filteredArray = [];
        if(!empty($listing)){
            $filteredArray = array_filter($listing, function($item) {
                return !isset($item['info']['extension']);
            });
        }
        return $filteredArray;
    }

    public function getAllFolders($dir = false, $excludeCurrentListFolder = true){
        $folders = [];

        if(!$dir){
            $dir = $this->uploadFolder;

            if(isset($_GET['content'])){
                $folders[] = EzFile::pathInfo($dir, true);
                $folders[0]['main_folder'] = true;
            }
        }

        if ($handle = opendir($dir)) {
            while (($item = readdir($handle)) !== false) {
                if ($item != "." && $item != "..") {
                    if (is_dir($dir . '/' . $item)) {
                        $add = true;
                        if($excludeCurrentListFolder && isset($_GET['content'])){
                            if(strpos($dir . '/' . $item, $_GET['content']) !== false){
                                $add = false;
                            }
                        }

                        if($add){
                            $folders[] = EzFile::pathInfo($dir . '/' . $item, true);
                        }
                        $subfolders = $this->getAllFolders($dir . '/' . $item);
                        $folders = array_merge($folders, $subfolders);
                    }
                }
            }
            closedir($handle);
        }

        return $folders;
    }

    private function getStoragePath($filepath){
        $path = str_replace("/", "\\", self::STORAGE_PATH)."\\".$this->user['id'];
        $fixedPath = str_replace("../storage", "", $filepath);
        $fixedPath = str_replace("storage", "", str_replace($this->user['id']."/", "", $fixedPath));
        $fixedPath = str_replace("/", "\\", $fixedPath);

        if(substr($fixedPath, 0, 1) === "\\"){
            $fixedPath = $path.$fixedPath;
        } else {
            $fixedPath = $path."\\".$fixedPath;
        }

        return $fixedPath;
    }
}