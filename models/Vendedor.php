<?php

namespace App;

class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'imagen'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar() {
        
        if(!$this->nombre) {
            self::$errores[] = 'El nombre es obligatorio';
        }
        if(!$this->apellido) {
            self::$errores[] = 'El apellido es obligatorio';
        }
        if(!$this->telefono) {
            self::$errores[] = 'El teléfono es obligatorio';
        }
        // Expresion regular
        if(!preg_match( '/[]0-9]{10}/', $this->telefono )) {
            self::$errores[] = 'Formato no Válido ';
        }
        if(!$this->imagen) {
            self::$errores[] = 'La imagen del vendedor es obligatoria';
        }

        return self::$errores;
    }
}