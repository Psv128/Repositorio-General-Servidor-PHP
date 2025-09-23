
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
        <!-- Sección de presentación personal -->
        <section>
            <img src="pikmin.png" alt="Foto" width="200">
            <p> Soy desarrollador web con experiencia en HTML, CSS, java etc. </p>
        </section>
        <!-- Navegación a otras páginas del sitio -->
        <nav>
            <h2>Mis páginas:</h2>
            <ul>
                <li><a href="tecnologia.php">Tecnologia Lista</a></li>
                <li><a href="tecnologias.php">Tecnologias Ordenada</a></li>
                <li><a href="rrss.php">Redes Sociales</a></li>
                <li><a href="server.php">Server</a></li>
                <li><a href="consulta.php">Consulta</a></li>
            </ul>
        </nav>
        <!-- Sección de contacto -->
        <section>
            <h2>Contacto</h2>
            <p>
                <a href="mailto:psvsolis@gmail.com">Escríbeme un correo electrónico</a>
            </p>
            <form action="consulta.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required><br><br>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="checkbox">tick</label>
                <input type="checkbox" id="checkbox" name="checkbox"><br><br>
                <label for="date">fecha</label>
                <input type="date" id="date" name="date"><br><br>
                <label for="consulta">Consulta:</label><br>
                <textarea id="consulta" name="consulta" rows="4" cols="40" required></textarea><br><br>
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