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
    die("Error: " . $e->getMessage());
}

if (!isset($_GET['cod'])) {
    header("Location: index.php");
    exit;
}

$album = $_GET['cod'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $stmt = $dwes->prepare("INSERT INTO cancion (titulo, album, posicion, duracion, genero) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['titulo'],
            $album,
            $_POST['posicion'],
            $_POST['duracion'],
            $_POST['genero']
        ]);
        echo "<p style='color:green;'>✅ Canción añadida correctamente.</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

<h2>Añadir canción al álbum <?= htmlspecialchars($album) ?></h2>
<form method="post">
    Título: <input type="text" name="titulo" required><br>
    Posición: <input type="number" name="posicion"><br>
    Duración: <input type="text" name="duracion"><br>
    Género: <input type="text" name="genero"><br>
    <button type="submit">Guardar</button>
</form>
<a href="album.php?cod=<?= htmlspecialchars($album) ?>">⬅️ Volver al álbum</a>

</body>
</html>
