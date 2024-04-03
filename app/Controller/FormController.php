<?php

namespace App\Controller;

class FormController extends Controller{

    public function copy(){
        $list = new ManagerController();
        $list = $list->getFolders();
        return $this->view('home/forms/copy', [
            'listing' => $list, 'current' => isset($_GET['content']) ? $_GET['content'] : '/'
        ]);
    }

    public function rename(){return $this->view('home/forms/rename');}
    public function uploadFile(){return $this->view('home/forms/upload-file');}
    public function uploadFolder(){return $this->view('home/forms/upload-folder'); }
}