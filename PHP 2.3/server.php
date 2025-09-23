
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Server</title>
</head>
<body>
    <!-- Cabecera común -->
    <header>
        <?php
        include 'cabecera.inc.php';
        ?>
    </header>
    <main>
        <!-- Sección principal: muestra el contenido de $_SERVER -->
        <section>
            <h2>Contenido de $_SERVER</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Recorrer el array $_SERVER y mostrar cada clave y valor en la tabla
                foreach ($_SERVER as $clave => $valor) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($clave) . '</td>';
                    if (is_array($valor)) {
                        echo '<td>';
                        foreach ($valor as $k => $v) {
                            echo htmlspecialchars($k) . ' => ' . htmlspecialchars($v) . '<br>';
                        }
                        echo '</td>';
                    } else {
                        echo '<td>' . htmlspecialchars($valor) . '</td>';
                    }
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </section>
        <!-- Navegación para volver a la página principal -->
        <nav>
            <a href="principal.php">Volver a la página principal</a>
        </nav>
    </main>
    <!-- Pie de página común -->
    <footer>
        <?php 
        include 'footer.inc.php'; 
        ?>
    </footer>
</body>
</html>