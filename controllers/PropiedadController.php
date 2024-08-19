<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        
        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado
        ]);
    }
    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $Vendedores = Vendedor::all();
        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* Crea una nueva Instancia */
            $propiedad = new Propiedad($_POST['propiedad']);
            $tipo = 'propiedades';

            // Obtener la carpeta de imagenes correspondiente
            $carpetaImagenes = getCarpetaImagenes($tipo);

            /* SUBIDA DE ARCHIVOS */
            // Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

            // Setear la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);
                $propiedad->setImagen($nombreImagen);
            }

            // Validar
            $errores = $propiedad->validar();

            // echo "<pre>";
            // var_dump($_POST);
            // echo "</pre>";
            
            // debuguear($carpetaImagenes . $nombreImagen);

            // echo "<pre>";
            // var_dump($errores);
            // echo "</pre>";

            // Revisar que el array de errores este vacio
            if(empty($errores)) {

                // Crear la carpeta para subir imagenes
                if(!is_dir($carpetaImagenes)) {
                    mkdir($carpetaImagenes);
                }

                // Guarda la imagen en el servidor
                $image->save($carpetaImagenes . $nombreImagen);

                // Guarda en la base de datos
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $Vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router) {
        
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $Vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $Vendedores
        ]);
    }
}