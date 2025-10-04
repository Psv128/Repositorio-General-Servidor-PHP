<?php
class Soporte {
    // Atributos
    public $titulo;
    protected $numero;
    protected $precio;

    // Constante IVA
    private const VAT = 0.21;

    // Constructor
    public function __construct($titulo, $numero, $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    // Getter Precio
    public function getPrecio() {
        return $this->precio;
    }

    // Getter Precio con IVA
    public function getPrecioConIVA() {
        return $this->precio * (1 + self::VAT);
    }

    // Getter Numero
    public function getNumero() {
        return $this->numero;
    }

    // Mostrar resumen
    public function muestraResumen() {
        echo "<br>Resumen del soporte:";
        echo "<br>Título: " . $this->titulo;
        echo "<br>Número: " . $this->numero;
        echo "<br>Precio: " . $this->precio . " euros";
    }

    // Setters y Getters adicionales
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }
}
?>
