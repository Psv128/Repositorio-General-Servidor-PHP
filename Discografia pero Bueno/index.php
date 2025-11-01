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

echo "<h1>🎵 Discografía</h1>";

// Mostrar mensaje si viene de redirección
if (isset($_GET['msg'])) {
    echo "<p style='color:green;'><b>" . htmlspecialchars($_GET['msg']) . "</b></p>";
}

// Mostrar álbumes
$stmt = $dwes->query("SELECT * FROM album ORDER BY codigo");
$albumes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($albumes)) {
    echo "<p>No hay álbumes registrados.</p>";
} else {
    echo "<ul>";
    foreach ($albumes as $a) {
        echo '<li><a href="album.php?cod=' . htmlspecialchars($a['codigo']) . '">'
            . htmlspecialchars($a['titulo']) . '</a></li>';
    }
    echo "</ul>";
}

// Enlaces
echo "<hr>";
echo '<a href="albumnuevo.php">➕ Añadir nuevo álbum</a><br>';
echo '<a href="canciones.php">🔍 Buscar canciones</a>';
?>

</body>
</html>