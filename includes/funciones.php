<?php


define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
// define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function getCarpetaImagenes(string $tipo) {
    $carpetaImagenes = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/';

    if($tipo === 'propiedades') {
        $carpetaImagenes .= 'propiedades/';
    } else if($tipo === 'vendedores') {
        $carpetaImagenes .= 'vendedores/';
    } else if($tipo === 'articulos') {
        $carpetaImagenes .= 'articulos/';
    }

    return $carpetaImagenes;
}

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() {
    session_start();
    // echo '<pre>';
    // var_dump($_SESSION);
    // echo '</pre>';
    if(!$_SESSION['login']) {
        header('Location: /');
    }
}

function debuguear($variable) {
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad', 'articulo'];
    return in_array($tipo, $tipos);
}

// Muestra los mensajes
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function validarORedireccionar(string $url) {
        // Validar la URL por ID valido
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
    
        if(!$id) {
            header("location: {$url}");
        }

        return $id;
}