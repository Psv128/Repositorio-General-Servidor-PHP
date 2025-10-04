<?php
require_once "Soporte.php";

class Dvd extends Soporte {
    private $idiomas;
    private $formatoPantalla;

    public function __construct($titulo, $numero, $precio, $idiomas, $formatoPantalla) {
        // Llamar al constructor del padre
        parent::__construct($titulo, $numero, $precio);

        // Inicializar los nuevos atributos
        $this->idiomas = $idiomas;
        $this->formatoPantalla = $formatoPantalla;
    }

    // Getters
    public function getIdiomas() {
        return $this->idiomas;
    }

    public function getFormatoPantalla() {
        return $this->formatoPantalla;
    }

    // Sobrescribir muestraResumen()
    public function muestraResumen() {
        echo "<br>Película en DVD:";
        echo "<br>" . $this->titulo;
        echo "<br>" . $this->precio . " € (IVA no incluido)";
        echo "<br>Idiomas: " . $this->idiomas;
        echo "<br>Formato Pantalla:" . $this->formatoPantalla;
    }
}
?>
