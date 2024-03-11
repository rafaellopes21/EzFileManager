<?php

namespace App\Controller;

class Controller{

    public static function view($view, $dataSecondView = []) {
        if(isset($_GET['instantLoad'])){
            unset($_GET['instantLoad']);
            return self::render($view, $dataSecondView);
        } else {
            $dataContent = $dataSecondView;
            $dataContent['main_content'] = $view;
            return self::render('index', $dataContent);
        }
    }

    public static function render($view, $viewData = []){
        \Flight::set('flight.views.path', __DIR__.'/../../resources/views');
        return \Flight::render($view, $viewData);
    }
}