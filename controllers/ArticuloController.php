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
            $errores = $articulo->validar();

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

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $articulo = Articulo::find($id);

        $errores = Articulo::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['articulo'];
            $tipo = 'articulos';

            // Sincronizar objeto en memoria con lo que que el usuario escribio
            $articulo->sincronizar($args);

            // Validacion
            $errores = $articulo->validar();

            // Obtener la carpeta de imagenes correspondiente
            $carpetaImagenes = getCarpetaImagenes($tipo);

            /* Subida de archivos */
            // Generar un nombre unico
            $nombreImagen = md5(uniqid( rand(), true) ) . ',jpg';

            if($_FILES['articulo']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['articulo']['tmp_name']['imagen'])->cover(800, 600);
                $articulo->setImagen($nombreImagen);
            }

            if(empty($errores)) {
                if($_FILES['articulo']['tmp_name']['imagen']) {
                    $image->save($carpetaImagenes . $nombreImagen);
                }
                $articulo->guardar();
            }
        }

        $router->render('/articulos/actualizar', [
            'articulo' => $articulo,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                // Valida el tipo a eliminar
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)) {
                    $articulo = Articulo::find($id);
                    $articulo->eliminar();
                }
            }
        }
    }
}