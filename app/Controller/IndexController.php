<?php

namespace App\Controller;

class IndexController extends Controller {

    public function index(){

        //construir e melhorar a função view para chamar apenas uma vez e ela ser responsável por chamar o numero x de layoutRender

        $this->view('layouts/body', [], 'bodyContent');
        return $this->view('index', ['hello' => 'Hello World']);
    }
}