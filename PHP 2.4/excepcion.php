
<?php
class MiExcepcion extends Exception {
    public function errorMessage() {
        return "¡Error personalizado!: " . $this->getMessage();
    }
}

function dividir($a, $b) {
    if (!is_numeric($a) || !is_numeric($b)) {
        throw new MiExcepcion("Ambos parámetros deben ser números.");
    }
    if ($b == 0) {
        throw new MiExcepcion("No se puede dividir por cero.");
    }
    return $a / $b;
}

$numero1 = $_POST['numero1'] ?? '';
$numero2 = $_POST['numero2'] ?? '';
$resultado = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $resultado = dividir($numero1, $numero2);
    } catch (MiExcepcion $e) {
        $error = $e->errorMessage();
    }
}
?>

<form method="post">
    <label>Dividendo: <input type="text" name="numero1" value="<?= htmlspecialchars($numero1) ?>"></label><br>
    <label>Divisor: <input type="text" name="numero2" value="<?= htmlspecialchars($numero2) ?>"></label><br>
    <button type="submit">Dividir</button>
</form>

<?php
if ($resultado !== '') {
    echo "El resultado de dividir $numero1 entre $numero2 es: $resultado";
}
if ($error) {
    echo $error;
}
?>