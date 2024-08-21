<?php

namespace Model;

class Articulo extends ActiveRecord {

    protected static $tabla = 'articulos';
    protected static $columnasDB = ['id', 'titulo', 'descripcion', 'creado', 'autor', 'imagen'];

    public $id;
    public $titulo;
    public $descripcion;
    public $creado;
    public $autor;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->creado = date('Y/m/d');
        $this->autor = $args['autor'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = 'El titulo es obligatorio';
        }
        if(strlen($this->descripcion) < 50) {
            self::$errores[] = 'La descripción es obligatorio';
        }
        if(!$this->autor) {
            self::$errores[] = 'El autor es obligatorio';
        }
        if(!$this->imagen) {
            self::$errores[] = 'La imagen del articulo es obligatoria';
        }
        return self::$errores;
    }
}