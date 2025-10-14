<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "dwes", "dwes", "tienda");

// Comprobar si hay error al conectar
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener los productos
$consulta = "SELECT * FROM producto";
$resultado = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
</head>
<body>
    <h1>Listado de Productos</h1>

    <table border="1" cellpadding="5">
        <tr>
            <th>Código</th>
            <th>Nombre Corto</th>
            <th>Precio (€)</th>
            <th>Familia</th>
        </tr>

        <?php
        if (mysqli_num_rows($resultado) > 0) {
            // Recorremos los productos y los mostramos
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila["cod"] . "</td>";

                // 🔹 Aquí añadimos el enlace al nombre corto
                echo "<td><a href='stock.php?cod=" . $fila["cod"] . "'>" . $fila["nombre_corto"] . "</a></td>";

                echo "<td>" . $fila["PVP"] . " €</td>";
                echo "<td>" . $fila["familia"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </table>
</body>
</html>
