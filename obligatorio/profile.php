<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?php echo htmlspecialchars($user['usuario']); ?></title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($user['usuario']); ?></h2>
    <img src="<?php echo htmlspecialchars($user['ruta_imagen']); ?>" alt="Mini foto" width="72" height="96">
    <hr>
    <h3>Datos del usuario</h3>
    <p><b>Usuario:</b> <?php echo htmlspecialchars($user['usuario']); ?></p>
    <p><b>Imagen grande:</b><br><img src="<?php echo htmlspecialchars($user['ruta_imagen_grande']); ?>" width="360" height="480"></p>

    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
