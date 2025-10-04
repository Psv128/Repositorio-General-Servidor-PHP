<?php
require_once "Soporte.php";

class Juego extends Soporte {
    private $consola;
    private $minNumJugadores;
    private $maxNumJugadores;

    // Constructor
    public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {
        // Llamar al constructor del padre
        parent::__construct($titulo, $numero, $precio);

        // Inicializar nuevos atributos
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    // Getter consola
    public function getConsola() {
        return $this->consola;
    }

    // Método que muestra posibles jugadores
    public function muestraJugadoresPosibles() {
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            echo "Para un jugador";
        } elseif ($this->minNumJugadores == $this->maxNumJugadores) {
            echo "Para " . $this->minNumJugadores . " jugadores";
        } else {
            echo "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores";
        }
    }

    // Sobrescribir muestraResumen()
    public function muestraResumen() {
        echo "<br>Juego para: " . $this->consola;
        echo "<br>" . $this->titulo;
        echo "<br>" . $this->getPrecio() . " € (IVA no incluido)";
        echo "<br>";
        $this->muestraJugadoresPosibles();
    }
}
?>
