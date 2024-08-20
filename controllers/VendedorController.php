<?php

namespace Controllers;
use Model\Vendedor;
use MVC\Router;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class VendedorController {
    public static function crear(Router $router) {

        $vendedor = new Vendedor;
        // Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* Crea una nueva instancia */
            $vendedor = new Vendedor($_POST['vendedor']);
            $tipo = 'vendedores';

            // Obtener la carpeta de imagenes correspondiente
            $carpetaImagenes = getCarpetaImagenes($tipo);

            /* Subida de archivos */
            // Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true) ) . '.jpg';

            // Seterar la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES['vendedor']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['vendedor']['tmp_name']['imagen'])->cover(800, 600);
                $vendedor->setImagen($nombreImagen);
            }

            // Validar
            $errores = $vendedor->validar();

            // Revisar que el array de errores este vacio
            if(empty($errores)) {
                // Crea la carpeta para subir imagenes
                if(!is_dir($carpetaImagenes)) {
                    mkdir($carpetaImagenes);
                }

                // Guarda la imagen en el servidor
                $image->save($carpetaImagenes . $nombreImagen);

                // Guardar en la base de datos
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizar() {
        echo 'actualizar vendedor';
    }

    public static function eliminar() {
        echo 'eliminar vendedor';
    }
}