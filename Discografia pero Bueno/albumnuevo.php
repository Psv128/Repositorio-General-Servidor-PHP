<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Discografía</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $stmt = $dwes->prepare("INSERT INTO album (codigo, titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['codigo'],
            $_POST['titulo'],
            $_POST['discografica'],
            $_POST['formato'],
            $_POST['fecha_lanzamiento'],
            $_POST['fecha_compra'],
            $_POST['precio']
        ]);
        header("Location: index.php?msg=Álbum creado correctamente");
        exit;
    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

<h2>Nuevo álbum</h2>
<form method="post">
    Código: <input type="text" name="codigo" required><br>
    Título: <input type="text" name="titulo" required><br>
    Discográfica: <input type="text" name="discografica"><br>
    Formato: <input type="text" name="formato"><br>
    Fecha lanzamiento: <input type="date" name="fecha_lanzamiento"><br>
    Fecha compra: <input type="date" name="fecha_compra"><br>
    Precio (€): <input type="number" step="0.01" name="precio"><br>
    <button type="submit">Guardar</button>
</form>
<a href="index.php">⬅️ Volver</a>

</body>
</html>