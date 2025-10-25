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

echo "<h2>Buscar canciones</h2>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $buscar = "%" . $_POST['titulo'] . "%";
    $stmt = $dwes->prepare("SELECT * FROM cancion WHERE titulo LIKE ?");
    $stmt->execute([$buscar]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        echo "<ul>";
        foreach ($resultados as $r) {
            echo "<li>" . htmlspecialchars($r['titulo']) . " (" . htmlspecialchars($r['album']) . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No se encontraron canciones.</p>";
    }
}
?>

<form method="post">
    Título: <input type="text" name="titulo" required>
    <button type="submit">Buscar</button>
</form>
<a href="index.php">⬅️ Volver</a>

</body>
</html>
