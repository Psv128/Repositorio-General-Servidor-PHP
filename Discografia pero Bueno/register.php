<?php
session_start();

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($usuario === '' || $password === '' || $password2 === '') {
        $mensaje = '⚠️ Rellena todos los campos.';
    } elseif ($password !== $password2) {
        $mensaje = '❌ Las contraseñas no coinciden.';
    } else {
        try {
            $check = $dwes->prepare("SELECT id FROM tabla_usuarios WHERE usuario = :usuario");
            $check->execute([':usuario' => $usuario]);
            if ($check->fetch()) {
                $mensaje = '⚠️ Ese nombre de usuario ya existe.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = $dwes->prepare("INSERT INTO tabla_usuarios (usuario, password) VALUES (:usuario, :password)");
                $insert->execute([':usuario' => $usuario, ':password' => $hash]);

                $_SESSION['usuario_nombre'] = $usuario;
                setcookie('usuario_recordado', $usuario, time() + (7 * 24 * 60 * 60), '/');

                $mensaje = '✅ Registro exitoso. ¡Bienvenido, ' . htmlspecialchars($usuario) . '!';
            }
        } catch (PDOException $e) {
            $mensaje = '❌ Error en el registro: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: Arial; background:#f8f9fa; margin:0; padding:0; }
        .container { max-width:400px; margin:80px auto; background:white; padding:30px; border-radius:12px;
                     box-shadow:0 0 10px rgba(0,0,0,0.1); text-align:center; }
        input { width:100%; padding:8px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px; }
        button { background:#28a745; color:white; border:none; padding:10px 15px; border-radius:6px; cursor:pointer; }
        button:hover { background:#1e7e34; }
        .msg { margin-top:15px; font-weight:bold; }
        .links a { display:block; margin:5px 0; text-decoration:none; color:#007BFF; }
        .links a:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de usuario</h2>
        <form method="post" action="">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="password2" placeholder="Repite la contraseña" required>
            <button type="submit">Registrarse</button>
        </form>

        <?php if ($mensaje): ?><div class="msg"><?php echo htmlspecialchars($mensaje); ?></div><?php endif; ?>

        <div class="links">
            <a href="login.php">🔑 Volver al Login</a>
            <a href="index.php">🏠 Página principal</a>
            <a href="album.php">🎵 Álbumes</a>
            <a href="canciones.php">🎶 Canciones</a>
        </div>
    </div>
</body>
</html>
