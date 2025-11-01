<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Discografía - Buscar canciones</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        h2 { color: #333; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 8px; width: 200px; border-radius: 4px; border: 1px solid #ccc; }
        button { padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        ul { list-style: none; padding: 0; }
        li { background: #fff; margin-bottom: 5px; padding: 8px; border-radius: 6px; box-shadow: 0 0 3px rgba(0,0,0,0.1); }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
        .logout { position: fixed; top: 10px; right: 10px; }
        .recientes { margin-top: 20px; background: #fff; padding: 10px; border-radius: 6px; box-shadow: 0 0 3px rgba(0,0,0,0.1); }
    </style>
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
    die("Error: " . $e->getMessage());
}

echo "<h2>🎵 Buscar canciones</h2>";

$mensaje = "";
$resultados = [];
$busquedas = [];

// Leer cookie de búsquedas anteriores
if (isset($_COOKIE['ultimas_busquedas'])) {
    $busquedas = json_decode($_COOKIE['ultimas_busquedas'], true) ?? [];
}

// Si hay búsqueda nueva
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $buscar = trim($_POST['titulo'] ?? '');
    if ($buscar !== '') {
        $buscarSQL = "%" . $buscar . "%";
        $stmt = $dwes->prepare("SELECT * FROM cancion WHERE titulo LIKE ?");
        $stmt->execute([$buscarSQL]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($resultados) {
            echo "<ul>";
            foreach ($resultados as $r) {
                echo "<li>" . htmlspecialchars($r['titulo']) . " (" . htmlspecialchars($r['album']) . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se encontraron canciones con el título '<strong>" . htmlspecialchars($buscar) . "</strong>'.</p>";
        }

        // Guardar la búsqueda en la cookie (últimas 5)
        if (!in_array($buscar, $busquedas)) {
            array_unshift($busquedas, $buscar);
            if (count($busquedas) > 5) {
                array_pop($busquedas);
            }
            setcookie('ultimas_busquedas', json_encode($busquedas), time() + (7 * 24 * 60 * 60), '/');
        }
    }
}

// Mostrar formulario
?>
<form method="post" action="">
    <label for="titulo">Título: </label>
    <input type="text" name="titulo" id="titulo" required>
    <button type="submit">Buscar</button>
</form>

<?php
// Mostrar búsquedas recientes si existen
if (!empty($busquedas)) {
    echo "<div class='recientes'><strong>🕓 Últimas búsquedas:</strong><ul>";
    foreach ($busquedas as $b) {
        echo "<li><a href='?titulo=" . urlencode($b) . "'>" . htmlspecialchars($b) . "</a></li>";
    }
    echo "</ul></div>";
}

// Si se accede por GET con ?titulo=...
if (isset($_GET['titulo'])) {
    $buscar = "%" . $_GET['titulo'] . "%";
    $stmt = $dwes->prepare("SELECT * FROM cancion WHERE titulo LIKE ?");
    $stmt->execute([$buscar]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Resultados para '" . htmlspecialchars($_GET['titulo']) . "':</h3>";
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

<div style="margin-top:20px;">
    <a href="index.php">⬅️ Volver al inicio</a>
</div>

<div class="logout">
    <form action="login.php" method="get">
        <button type="submit" name="logout">Cerrar sesión</button>
    </form>
</div>

</body>
</html>
