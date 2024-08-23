<?php

namespace Controllers;

use Model\Articulo;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router) {
        $router->render('paginas/nosotros');
    }
    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router) {
        
        $id = validarORedireccionar('/propiedades');
        // Buscar la propiedad por su id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router) {

        $articulos = Articulo::all();

        $router->render('paginas/blog', [
            'articulos' => $articulos
        ]);
    }
    public static function entrada(Router $router) {

        $id = validarORedireccionar('/blog');
        // Buscar el blog por su id
        $articulo = Articulo::find($id);

        $router->render('paginas/entrada', [
            'articulo' => $articulo
        ]);
    }
    public static function contacto(Router $router) {

        // if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //     $respuestas = $_POST['contacto'];

        //     // Crear una instacia de PHPMailer
        //     $mail = new PHPMailer(true);

        //     // Configurar SMTP
        //     try {
        //         $mail->isSMTP();
        //         $mail->Host = 'sandbox.smtp.mailtrap.io';
        //         $mail->SMTPAuth = true;
        //         $mail->Username = '0809a6471fc3a9';
        //         $mail->Password = '6b3100de5288da';
        //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //         $mail->Port = 2525;

        //         // Configurar el contenido del mail
        //         $mail->setFrom('admin@bienesraices.com');
        //         $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
        //         $mail->Subject = 'Tienes un Nuevo Mensaje';
                
        //         // Habilitar HTML
        //         $mail->isHTML(true);
        //         $mail->CharSet = 'UTF-8';

        //         // Definir el contenido
        //         $contenido = '<html>';
        //         $contenido .= '<p>Tienes un nuevo mensaje</p>';
        //         $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
        //         $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
        //         $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
        //         $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
        //         $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
        //         $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';
        //         $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . '</p>';
        //         $contenido .= '<p>Fecha Contacto: ' . $respuestas['fecha'] . '</p>';
        //         $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
        //         $contenido .= '</html>';

        //         $mail->Body = $contenido;
        //         $mail->AltBody = 'Esto es texto alternativo sin HTML';

        //         // Habilitar la depuracion de SMTP
        //         $mail->SMTPDebug = 0;

        //         // Enviar el email
        //         $mail->send();
        //         echo 'Mensaje enviado Correctamente';
        //     } catch (Exception $error) {
        //         // Capturar y mostrar el error
        //         echo 'El mensaje no se pudo enviar. Error de Mailer: ' . $mail->ErrorInfo;
        //     }
        // }

        $router->render('paginas/contacto', [

        ]);
    }
}