<?php

namespace Controllers;
use Model\Articulo;
use MVC\Router;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class ArticuloController {
    public static function crear(Router $router) {

        $articulo = new Articulo;
        // Arreglo con mensajes de errores
        $errores = Articulo::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* Crea una nueva instancia */
            $articulo = new Articulo($_POST['articulo']);
            $tipo = 'articulos';

            // Obtener la carpeta de imagenes correspondiente
            $carpetaImagenes = getCarpetaImagenes($tipo);

            // Generar un nombre unico
            $nombreImagen = md5(uniqid( rand(), true) ) . '.jpg';

            // Seterar la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES['articulo']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['articulo']['tmp_name']['imagen'])->cover(800, 600);
                $articulo->setImagen($nombreImagen);
            }

            // Validar
            $errores = $articulo->valdiar();

            // Revisar que el array de errores este vacio
            if(empty($errores)) {
                // Crear la carpeta para subir imagenes
                if(!is_dir($carpetaImagenes)) {
                    mkdir($carpetaImagenes);
                }

                // Guardar Imagen en el servidor
                $image->save($carpetaImagenes . $nombreImagen);

                // Guardar en la base de datos
                $articulo->guardar();
            }
        }

        $router->render('articulos/crear', [
            'articulo' => $articulo,
            'errores' => $errores
        ]);
    }
}