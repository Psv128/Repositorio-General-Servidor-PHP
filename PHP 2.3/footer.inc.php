
<style>
    /* Estilos para el pie de página */
    footer {
        background-image: ; /* Puedes agregar una imagen de fondo si lo deseas */
        color: #000000;
        padding: 20px 0;
        text-align: center;
        font-family: Arial, sans-serif;
        border: 2px solid #000000;
        border-radius: 10%;
    }
</style>
<?php
// Obtener el nombre del día de la semana en español
$diaSemana = '';
switch (date('w')) {
    case 0: $diaSemana = 'domingo'; break;
    case 1: $diaSemana = 'lunes'; break;
    case 2: $diaSemana = 'martes'; break;
    case 3: $diaSemana = 'miércoles'; break;
    case 4: $diaSemana = 'jueves'; break;
    case 5: $diaSemana = 'viernes'; break;
    case 6: $diaSemana = 'sábado'; break;
}

// Obtener el nombre del mes en español
$mes = '';
switch (date('n')) {
    case 1: $mes = 'enero'; break;
    case 2: $mes = 'febrero'; break;
    case 3: $mes = 'marzo'; break;
    case 4: $mes = 'abril'; break;
    case 5: $mes = 'mayo'; break;
    case 6: $mes = 'junio'; break;
    case 7: $mes = 'julio'; break;
    case 8: $mes = 'agosto'; break;
    case 9: $mes = 'septiembre'; break;
    case 10: $mes = 'octubre'; break;
    case 11: $mes = 'noviembre'; break;
    case 12: $mes = 'diciembre'; break;
}

// Obtener el día y el año
$dia = date('d');
$anio = date('Y');

// Mostrar la fecha en formato español
echo "$diaSemana, $dia de $mes de $anio";
?>
