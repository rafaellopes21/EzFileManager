<?php

namespace App\Controller;

use flight\template\View;

class Controller{

    public static function view($view, $viewData = []){
        \Flight::set('flight.views.path', __DIR__.'/../../resources/views');
        return \Flight::render($view, $viewData);
    }
}