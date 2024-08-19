<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        $resultado = null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado
        ]);
    }
    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $Vendedores = Vendedor::all();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $Vendedores
        ]);
    }
    public static function actualizar() {
        echo 'Actualizar propiedad';
    }
}