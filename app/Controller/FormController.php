<?php

namespace App\Controller;

class FormController extends Controller{

    public function copyMove($copy){
        $list = new ManagerController();
        $list = $list->getAllFolders(false);
        return $this->view('home/forms/copy_move', [
            'listing' => $list,
            'current' => isset($_GET['content']) ? $_GET['content'] : '/',
            'ruleList' => $copy ? "copy" : "move",
        ]);
    }

    public function copy(){return $this->copyMove(true);}
    public function move(){return $this->copyMove(false);}
    public function rename(){return $this->view('home/forms/rename');}
    public function uploadFile(){return $this->view('home/forms/upload-file');}
    public function uploadFolder(){return $this->view('home/forms/upload-folder'); }
}