<?php

class CintaVideo extends Soporte {
    private $duration;

    public function getDuracion() {
        return $this->duration;
    }

    public function muestraResumen() {
        echo"<br>Pelicula En VHS:";
        echo "<br>Título: " . $this->getTitulo();
        echo "<br>Duración: " . $this->getDuracion() . " minutos";
    }

    public function __construct($title, $company, $price, $duration) {
        // Llamar al constructor del padre
        parent::__construct($title, $company, $price);
        // Nuevo atributo
        $this->duration = $duration;


    }

}
