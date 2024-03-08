<?php

namespace App\Controller;

class ManagerController extends Controller {

    public function index(){
        return $this->view('index', ['hello' => 'Hello World']);
    }

    public function teste(){
        return $this->view('teste/index', ['hello' => 'Hello World']);
    }
}