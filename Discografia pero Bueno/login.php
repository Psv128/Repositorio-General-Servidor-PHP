<?php
session_start();

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie('usuario_recordado', '', time() - 3600, '/');
    header("Location: login.php");
    exit;
}

if (isset($_GET['login_cookie']) && isset($_COOKIE['usuario_recordado'])) {
    $_SESSION['usuario_nombre'] = $_COOKIE['usuario_recordado'];
    $mensaje = 'Access successful';
}

if (isset($_GET['delete_cookie'])) {
    setcookie('usuario_recordado', '', time() - 3600, '/');
    header("Location: login.php");
    exit;
}

$mensaje = $mensaje ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario === '' || $password === '') {
        $mensaje = '⚠️ Introduce usuario y contraseña.';
    } else {
        try {
            $stmt = $dwes->prepare("SELECT id, password FROM tabla_usuarios WHERE usuario = :usuario LIMIT 1");
            $stmt->execute([':usuario' => $usuario]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($password, $row['password'])) {
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['usuario_nombre'] = $usuario;
                setcookie('usuario_recordado', $usuario, time() + (7 * 24 * 60 * 60), '/');
                $mensaje = 'Login successful';
            } else {
                $mensaje = '❌ Login failed. Usuario o contraseña incorrectos.';
            }
        } catch (PDOException $e) {
            $mensaje = 'Error en la consulta: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: Arial; background:#f8f9fa; margin:0; padding:0; }
        .container { max-width:400px; margin:80px auto; background:white; padding:30px; border-radius:12px;
                     box-shadow:0 0 10px rgba(0,0,0,0.1); text-align:center; }
        input[type="text"], input[type="password"] { width:100%; padding:8px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px; }
        button { background:#007BFF; color:white; border:none; padding:10px 15px; border-radius:6px; cursor:pointer; }
        button:hover { background:#0056b3; }
        .msg { color:red; margin-top:10px; font-weight:bold; }
        .logout { position:fixed; top:10px; right:10px; }
        .links a { display:block; margin:5px 0; text-decoration:none; color:#007BFF; }
        .links a:hover { text-decoration:underline; }
    </style>
</head>
<body>

<?php if (isset($_SESSION['usuario_nombre'])): ?>
    <div class="logout">
        <form action="login.php" method="get">
            <button type="submit" name="logout">Cerrar sesión</button>
        </form>
    </div>
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?> 👋</h2>
        <p>✅ <?php echo htmlspecialchars($mensaje ?: 'Login successful'); ?></p>
        <div class="links">
            <a href="index.php">🏠 Página principal</a>
            <a href="album.php">🎵 Álbumes</a>
            <a href="canciones.php">🎶 Canciones</a>
            <a href="register.php">➕ Registrar nuevo usuario</a>
        </div>
    </div>

<?php elseif (isset($_COOKIE['usuario_recordado'])): ?>
    <div class="container">
        <h2>¿Quieres iniciar sesión como <?php echo htmlspecialchars($_COOKIE['usuario_recordado']); ?>?</h2>
        <form method="get" action="">
            <button type="submit" name="login_cookie">Sí</button>
            <button type="submit" name="delete_cookie">No</button>
        </form>
    </div>

<?php else: ?>
    <div class="container">
        <h2>Iniciar sesión</h2>
        <form method="post" action="">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <?php if ($mensaje): ?><div class="msg"><?php echo htmlspecialchars($mensaje); ?></div><?php endif; ?>
        <div class="links">
            <a href="register.php">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
