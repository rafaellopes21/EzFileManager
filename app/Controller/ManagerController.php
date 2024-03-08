<?php

namespace App\Controller;

class ManagerController extends Controller {

    public function index(){
        return $this->view('index', ['hello' => 'Hello World']);
    }
}