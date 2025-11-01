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

$codigo = $_GET['cod'];

try {
    $dwes->beginTransaction();
    $dwes->prepare("DELETE FROM cancion WHERE album = ?")->execute([$codigo]);
    $dwes->prepare("DELETE FROM album WHERE codigo = ?")->execute([$codigo]);
    $dwes->commit();
    header("Location: index.php?msg=Álbum y canciones borrados correctamente");
    exit;
} catch (PDOException $e) {
    $dwes->rollBack();
    header("Location: album.php?cod=$codigo&msg=" . urlencode("Error al borrar: " . $e->getMessage()));
    exit;
}
?>

</body>
</html>
