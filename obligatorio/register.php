<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    // Validar imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $allowed = ['image/png', 'image/jpeg'];
        $file_type = mime_content_type($_FILES['imagen']['tmp_name']);
        $file_info = getimagesize($_FILES['imagen']['tmp_name']);
        $width = $file_info[0];
        $height = $file_info[1];

        if (!in_array($file_type, $allowed)) {
            $error = "Tipo de imagen no permitido. Solo PNG o JPG.";
        } elseif ($width > 360 || $height > 480) {
            $error = "La imagen supera el tamaño máximo (360x480px).";
        } else {
            // Crear carpeta del usuario
            $dir = "img/users/$usuario";
            if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
                die("Error: no se pudo crear el directorio $dir. Verifica permisos.");
            }

            $ext = ($file_type == 'image/png') ? 'png' : 'jpg';
            $big_name = "$dir/idUserBig.$ext";
            $small_name = "$dir/idUserSmall.$ext";

            // Guardar imagen grande (360x480)
            resizeImage($_FILES['imagen']['tmp_name'], $big_name, 360, 480);

            // Guardar imagen pequeña (72x96)
            resizeImage($_FILES['imagen']['tmp_name'], $small_name, 72, 96);

            // Guardar en DB (ya con contrasena sin ñ)
            $stmt = $dwes->prepare("INSERT INTO tabla_usuario (usuario, contrasena, ruta_imagen, ruta_imagen_grande) VALUES (?, ?, ?, ?)");
            $stmt->execute([$usuario, $password, $small_name, $big_name]);

            header("Location: login.php");
            exit;
        }
    } else {
        $error = "Debes subir una imagen de perfil.";
    }
}

function resizeImage($src, $dest, $new_w, $new_h) {
    $info = getimagesize($src);
    $mime = $info['mime'];
    if ($mime == 'image/jpeg') $image = imagecreatefromjpeg($src);
    else $image = imagecreatefrompng($src);

    $tmp = imagecreatetruecolor($new_w, $new_h);
    imagecopyresampled($tmp, $image, 0, 0, 0, 0, $new_w, $new_h, imagesx($image), imagesy($image));

    if ($mime == 'image/jpeg') imagejpeg($tmp, $dest, 90);
    else imagepng($tmp, $dest);

    imagedestroy($image);
    imagedestroy($tmp);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuario</title>
</head>
<body>
<h2>Registro</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post" enctype="multipart/form-data">
    <label>Usuario:</label><br>
    <input type="text" name="usuario" required><br>
    <label>Contraseña:</label><br>
    <input type="password" name="contrasena" required><br>
    <label>Imagen de perfil:</label><br>
    <input type="file" name="imagen" accept="image/png, image/jpeg" required><br><br>
    <input type="submit" value="Registrarse">
</form>

<a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</body>
</html>
