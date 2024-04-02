<?php

namespace App\Controller;

class FormController extends Controller{

    public function uploadFile(){
        return $this->view('home/forms/upload-file');
    }

    public function uploadFolder(){
        return $this->view('home/forms/upload-folder');
    }
}