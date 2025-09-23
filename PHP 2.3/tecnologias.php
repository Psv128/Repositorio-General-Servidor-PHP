
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presentación - Desarrollador Web</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <!-- Cabecera común -->
    <header>
        <?php
        include 'cabecera.inc.php';
        ?>
    </header>
    <main>
        <!-- Sección principal: lista ordenada de tecnologías -->
        <section>
            <ol>
                <li>MySQL</li>
                <li>Google Drive</li>
                <li>Gmail</li>
                <li>Google</li> 
                <li>Github</li>
            </ol>
        </section>
        <!-- Navegación para volver al inicio -->
        <nav>
            <h2>Mis páginas:</h2>
            <ul>
                <li><a href="principal.php">Inicio</a></li>
            </ul>
        </nav>
    </main>
</body>
<!-- Pie de página común -->
<footer>
        <?php 
        include 'footer.inc.php'; 
        ?>
</footer>
</html>