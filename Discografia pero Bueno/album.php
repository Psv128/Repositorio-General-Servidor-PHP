<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Discografía</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<?php

session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

if (!isset($_GET['cod'])) {
    header("Location: index.php");
    exit;
}

$codigo = $_GET['cod'];

// Obtener info del álbum
$stmt = $dwes->prepare("SELECT * FROM album WHERE codigo = ?");
$stmt->execute([$codigo]);
$album = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$album) {
    die("❌ Álbum no encontrado.");
}

echo "<h2>Álbum: " . htmlspecialchars($album['titulo']) . "</h2>";

echo "<p><b>Código:</b> " . htmlspecialchars($album['codigo']) . "<br>
<b>Discográfica:</b> " . htmlspecialchars($album['discografica']) . "<br>
<b>Formato:</b> " . htmlspecialchars($album['formato']) . "<br>
<b>Fecha de lanzamiento:</b> " . htmlspecialchars($album['fechaLanzamiento']) . "<br>
<b>Fecha de compra:</b> " . htmlspecialchars($album['fechaCompra']) . "<br>
<b>Precio:</b> " . htmlspecialchars($album['precio']) . " €</p>";

// Mostrar canciones
$stmt = $dwes->prepare("SELECT * FROM cancion WHERE album = ? ORDER BY posicion");
$stmt->execute([$codigo]);
$canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($canciones) {
    echo "<table border='1' cellpadding='5'>
            <tr><th>Título</th><th>Posición</th><th>Duración</th><th>Género</th></tr>";
    foreach ($canciones as $c) {
        echo "<tr>
                <td>" . htmlspecialchars($c['titulo']) . "</td>
                <td>" . htmlspecialchars($c['posicion']) . "</td>
                <td>" . htmlspecialchars($c['duracion']) . "</td>
                <td>" . htmlspecialchars($c['genero']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Este álbum no tiene canciones registradas.</p>";
}

echo "<br><a href='cancionnueva.php?cod=" . htmlspecialchars($album['codigo']) . "'>➕ Añadir canción</a><br>";
echo "<a href='borraralbum.php?cod=" . htmlspecialchars($album['codigo']) . "'>🗑️ Borrar álbum</a><br>";
echo "<br><a href='index.php'>⬅️ Volver a la lista</a>";
?>

</body>
</html>