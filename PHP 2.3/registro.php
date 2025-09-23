<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presentación - Desarrollador Web</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            margin: 0;
            padding: 0;
        }
        main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
        }
        section {
            background: #fff;
            padding: 2em 2.5em;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            margin-top: 2em;
            min-width: 320px;
            max-width: 400px;
        }
        section img {
            display: block;
            margin: 0 auto 1em auto;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            border: 8px solid red;
        }

        form label {
            display: block;
            margin-bottom: 0.5em;
            font-weight: 500;
        }
       
        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form input[type="date"],
        form select {
            width: 100%;
            padding: 0.5em;
            margin-top: 0.2em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
            background: #fafafa;
        }
        form input[type="checkbox"] {
            margin-right: 0.5em;
        }
        form button {
            background: #0078d4;
            color: #fff;
            border: none;
            padding: 0.7em 1.5em;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 1em;
            transition: background 0.2s;
        }
        form button:hover {
            background: #005fa3;
        }
        .error {
            color: red;
            font-size: 0.95em;
            margin-bottom: 1em;
            display: block;
        }
        @media (max-width: 500px) {
            section {
                padding: 1em;
                min-width: unset;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Cabecera común -->
    <header>
        <?php
        include 'cabecera.inc.php';
        ?>
    </header>
    <main>
        <!-- Sección de presentación personal -->
        <section>
            <img src="bulb.png" alt="Foto" width="200">
            <?php
            // Inicializar variables
            $mensaje = '';
            $valores = [
                'nombre' => '',
                'apellidos' => '',
                'nombre_usuario' => '',
                'email' => '',
                'date' => '',
                'genero' => '',
                'terminos' => '',
                'publicidad' => ''
            ];
            $contraseña = $confirmar_contraseña = '';

            // Si se envía el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                foreach ($valores as $campo => $valor) {
                    $valores[$campo] = htmlspecialchars($_POST[$campo] ?? '');
                }
                $contraseña = $_POST['contraseña'] ?? '';
                $confirmar_contraseña = $_POST['confirmar_contraseña'] ?? '';
                $valores['terminos'] = isset($_POST['terminos']) ? 'checked' : '';
                $valores['publicidad'] = isset($_POST['publicidad']) ? 'checked' : '';

                if ($contraseña !== $confirmar_contraseña) {
                    $mensaje = '<span style="color:red;">Las contraseñas no coinciden.</span>';
                } else {
                    $mensaje = '<span style="color:green;">¡Registro completado correctamente!</span>';
                    // Vaciar campos
                    foreach ($valores as $campo => $valor) {
                        $valores[$campo] = '';
                    }
                    $contraseña = $confirmar_contraseña = '';
                }
            }
            echo $mensaje;
            ?>
            <form action="" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required value="<?= $valores['nombre'] ?>"><br><br>

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required value="<?= $valores['apellidos'] ?>"><br><br>

                <label for="nombre_usuario">Nombre de usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required value="<?= $valores['nombre_usuario'] ?>"><br><br>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required value="<?= $valores['email'] ?>"><br><br>

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required value="<?= $contraseña ?>"><br><br>

                <label for="confirmar_contraseña">Confirmación De Contraseña:</label>
                <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" required value="<?= $confirmar_contraseña ?>"><br><br>

                <label for="date">Fecha De Nacimiento</label>
                <input type="date" id="date" name="date" value="<?= $valores['date'] ?>"><br><br>

                <label for="genero">Genero</label>
                <select id="genero" name="genero">
                    <option value="">Selecciona</option>
                    <option value="masculino" <?= $valores['genero']=='masculino'?'selected':'' ?>>Masculino</option>
                    <option value="femenino" <?= $valores['genero']=='femenino'?'selected':'' ?>>Femenino</option>
                    <option value="otro" <?= $valores['genero']=='otro'?'selected':'' ?>>Otro</option>
                </select><br><br>

                <label for="terminos">Terminos Y Condiciones</label>
                <input type="checkbox" id="terminos" name="terminos" <?= $valores['terminos'] ?>><br><br>

                <label for="publicidad">Publicidad</label>
                <input type="checkbox" id="publicidad" name="publicidad" <?= $valores['publicidad'] ?>><br><br>

                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>
    <!-- Pie de página común -->
    <footer>
        <?php 
        include 'footer.inc.php'; 
        ?>
    </footer>
</body>
</html>