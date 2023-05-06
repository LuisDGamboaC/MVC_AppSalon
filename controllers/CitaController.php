<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index( Router $router) {

        session_start();

        isAUTH(); // si esta autenticado o no

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
        
    }
}