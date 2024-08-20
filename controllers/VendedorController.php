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

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $vendedor = Vendedor::find($id);

        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['vendedor'];
            $tipo = 'vendedores';

            // Sincronizar objeto en memoria con lo que el usuario escribio
            $vendedor->sincronizar();

            // Validacion
            $errores = $vendedor->validar();

            // Obtener la carpeta de imagenes correspondiente
            $carpetaImagenes = getCarpetaImagenes($tipo);

            /* Subida de archivos */
            // Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

            if($_FILES['vendedor']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['vendedor']['tmp_name']['imagen'])->cover(800, 600);
                $vendedor->setImagen($nombreImagen);
            }

            if(empty($errores)) {
                if($_FILES['vendedor']['tmp_name']['imagen']) {
                    $image->save($carpetaImagenes . $nombreImagen);
                }
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            

            // Validar el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                // valida el tipo a eliminar
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }

    }
}