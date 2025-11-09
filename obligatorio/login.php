<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['contrasena'];

    $stmt = $dwes->prepare("SELECT * FROM tabla_usuario WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['contrasena'])) {
        $_SESSION['user'] = $user;
        header("Location: profile.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
<h2>Iniciar sesión</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br>
    <label>Contraseña:</label><br>
    <input type="password" name="contrasena" required><br><br>
    <input type="submit" value="Entrar">
</form>
</body>
</html>
