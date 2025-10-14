<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "dwes", "dwes", "tienda");

// Comprobar conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Si se ha enviado el formulario para actualizar
if (isset($_POST['actualizar'])) {
    $codProducto = $_POST['codProducto'];
    $codTienda = $_POST['codTienda'];
    $nuevasUnidades = $_POST['nuevasUnidades'];

    // Actualizar el stock en la base de datos
    $update = "
        UPDATE stock
        SET unidades = '$nuevasUnidades'
        WHERE producto = '$codProducto' AND tienda = '$codTienda'
    ";

    if (mysqli_query($conexion, $update)) {
        echo "<p style='color:green;'>✅ Stock actualizado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al actualizar el stock.</p>";
    }
}

// Obtener el código del producto desde la URL
if (isset($_GET['cod'])) {
    $codProducto = $_GET['cod'];

    // Consulta para obtener el stock del producto
    $consulta = "
        SELECT tienda.cod AS cod_tienda, tienda.nombre AS tienda, stock.unidades
        FROM stock
        JOIN tienda ON stock.tienda = tienda.cod
        WHERE stock.producto = '$codProducto'
    ";

    $resultado = mysqli_query($conexion, $consulta);
} else { 
    die("No se ha indicado ningún producto.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Stock</title>
</head>
<body>
    <h1>Modificar stock del producto: <?= htmlspecialchars($codProducto) ?></h1>
    <p><a href="index.php">← Volver al listado</a></p>

    <table border="1" cellpadding="5">
        <tr>
            <th>Tienda</th>
            <th>Unidades actuales</th>
            <th>Modificar</th>
        </tr>

        <?php
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila["tienda"]) . "</td>";
                echo "<td>" . $fila["unidades"] . "</td>";

                // 🔹 Formulario individual por tienda
                echo "<td>
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='codProducto' value='" . $codProducto . "'>
                            <input type='hidden' name='codTienda' value='" . $fila["cod_tienda"] . "'>
                            <input type='number' name='nuevasUnidades' value='" . $fila["unidades"] . "' min='0'>
                            <input type='submit' name='actualizar' value='Actualizar'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay stock disponible para este producto.</td></tr>";
        }

        mysqli_close($conexion);
        ?>
    </table>
</body>
</html>
