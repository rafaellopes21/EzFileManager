<?php

namespace App\Controller;

use flight\template\View;

class Controller{

    public function view($view, $viewData, $layoutRender = false){
        \Flight::set('flight.views.path', __DIR__.'/../../resources/views');
        return $layoutRender ? \Flight::render($view, $viewData, $layoutRender) : \Flight::render($view, $viewData);
    }
}