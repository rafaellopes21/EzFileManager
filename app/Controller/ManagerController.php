<?php

namespace App\Controller;

class ManagerController extends Controller {

    public function index(){
        return $this->view('home/index', ['title' => 'Hello World']);
    }
}