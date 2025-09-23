
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
            <img src="pikmin.png" alt="Foto" width="600">

            <?php
                echo 'El alumno ';
                echo $_POST['nombre'] .' , que tiene como email, '. $_POST['email'];
                echo ' , Y ha marcado en el checkbox como : ' . ($_POST['checkbox'] ? 'Sí' : 'No');
            ?>

            
    </main>
    <!-- Pie de página común -->
    <footer>
        <?php 
        include 'footer.inc.php'; 
        ?>
    </footer>
</body>
</html>