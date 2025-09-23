<?php
function sumar($a, $b) {
    if (!is_numeric($a) || !is_numeric($b)) {
        throw new Exception("Ambos parámetros deben ser números.");
    }
    return $a + $b;
}

$numero1 = $_POST['numero1'] ?? '';
$numero2 = $_POST['numero2'] ?? '';
$resultado = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $resultado = sumar($numero1, $numero2);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<form method="post">
    <label>Primer número: <input type="text" name="numero1" value="<?= htmlspecialchars($numero1) ?>"></label><br>
    <label>Segundo número: <input type="text" name="numero2" value="<?= htmlspecialchars($numero2) ?>"></label><br>
    <button type="submit">Sumar</button>
</form>

<?php
if ($resultado !== '') {
    echo "La suma de $numero1 y $numero2 es: $resultado";
}
if ($error) {
    echo "Excepción capturada: " . $error;
}
?>
