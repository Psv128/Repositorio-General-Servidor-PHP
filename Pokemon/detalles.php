<?php
// detalles.php

if (!isset($_GET['id'])) {
    echo "<p>Error: No se especificó un Pokémon.</p>";
    exit;
}

$id = intval($_GET['id']);

$api_url = "https://pokeapi.co/api/v2/pokemon/$id";
$species_url = "https://pokeapi.co/api/v2/pokemon-species/$id";

$poke_data = json_decode(@file_get_contents($api_url), true);
$species_data = json_decode(@file_get_contents($species_url), true);

if (!$poke_data) {
    echo "<p>Error al obtener datos de la API (Pokémon).</p>";
    exit;
}

if (!$species_data) {
    echo "<p>Error al obtener datos de la API (Especie).</p>";
    exit;
}

// Datos generales
$name = $poke_data['name'];
$img = $poke_data['sprites']['other']['official-artwork']['front_default'];
$types = array_map(fn($t) => $t['type']['name'], $poke_data['types']);
$abilities = array_map(fn($a) => $a['ability']['name'], $poke_data['abilities']);
$stats = $poke_data['stats'];

// Descripción en español
$desc = "Sin descripción disponible.";
foreach ($species_data['flavor_text_entries'] as $entry) {
    if ($entry['language']['name'] === 'es') {
        $desc = str_replace(["\n","\f"], " ", $entry['flavor_text']);
        break;
    }
}

// Color dinámico según tipo
$main_type = $types[0];
$type_colors = [
    "water" => "linear-gradient(180deg, #004f9e, #6cb4ff)",
    "fire" => "linear-gradient(180deg, #ff4500, #ff9d00)",
    "ice" => "linear-gradient(180deg, #b3ecff, #e6f9ff)",
    "steel" => "linear-gradient(180deg, #d9d9d9, #a6a6a6)",
    "bug" => "linear-gradient(180deg, #ccff99, #99cc66)",
    "grass" => "linear-gradient(180deg, #00b300, #006600)",
    "dark" => "linear-gradient(180deg, #000000, #003300)",
    "psychic" => "linear-gradient(180deg, #ff99cc, #ff66b3)",
    "fairy" => "linear-gradient(180deg, #ffd6eb, #ffb3d9)",
    "ground" => "linear-gradient(180deg, #a66a29, #cc9966)",
    "rock" => "linear-gradient(180deg, #4d3319, #806040)",
    "poison" => "linear-gradient(180deg, #800080, #b300b3)",
    "electric" => "linear-gradient(180deg, #ffeb3b, #ff9800)",
    "fighting" => "linear-gradient(180deg, #760000, #cc3300)",
    "flying" => "linear-gradient(180deg, #cce6ff, #cc99ff)",
    "dragon" => "linear-gradient(180deg, #001a66, #4d0099)",
    "ghost" => "linear-gradient(180deg, #2e003e, #000000)",
    "normal" => "linear-gradient(180deg, #e6e6e6, #cccccc)"
];
$gradient = $type_colors[$main_type] ?? $type_colors["normal"];

// Función para obtener icono seguro
function getTypeIcon($type) {
    $type = strtolower(trim($type));
    $path = __DIR__ . "/img/types/$type.png"; // ruta física del archivo
    if (file_exists($path)) {
        return "img/types/$type.png"; // ruta relativa para HTML
    }
    return "img/types/default.png"; // icono por defecto
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalles de <?= ucfirst($name) ?></title>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        color: #fff;
        text-align: center;
        background: <?= $gradient ?>;
        min-height: 100vh;
    }
    .container {
        width: 90%;
        max-width: 900px;
        margin: 40px auto;
        background: rgba(255, 255, 255, 0.12);
        padding: 25px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0px 0px 20px rgba(0,0,0,0.3);
    }
    .poke-name {
        font-size: 42px;
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: capitalize;
    }
    .poke-img {
        width: 260px;
        height: 260px;
        object-fit: contain;
        margin-bottom: 20px;
        filter: drop-shadow(0px 0px 15px rgba(0,0,0,0.5));
    }
    .section {
        margin-top: 30px;
        padding: 18px;
        background: rgba(0,0,0,0.25);
        border-radius: 15px;
        text-align: left;
    }
    .section h2 {
        margin-top: 0;
        font-size: 26px;
        border-bottom: 2px solid rgba(255,255,255,0.4);
        padding-bottom: 6px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        font-size: 18px;
    }
    .back-btn {
        display: inline-block;
        margin-top: 35px;
        padding: 12px 25px;
        background: rgba(0,0,0,0.45);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-size: 18px;
        transition: 0.3s;
    }
    .back-btn:hover { background: rgba(0,0,0,0.7); }
    .type-icon {
        width: 32px;
        height: 32px;
        vertical-align: middle;
        margin-right: 6px;
        filter: drop-shadow(0px 0px 4px rgba(0,0,0,0.4));
    }
</style>
</head>
<body>
<div class="container">

    <div class="poke-name">
        <?= ucfirst($name) ?>
        <img src="<?= getTypeIcon($main_type) ?>" class="type-icon" alt="<?= $main_type ?>">
    </div>

    <img class="poke-img" src="<?= $img ?>" alt="<?= $name ?>">

    <div class="section">
        <h2>Descripción</h2>
        <p><?= $desc ?></p>
    </div>

    <div class="section">
        <h2>Tipos</h2>
        <p>
            <?php foreach ($types as $t): ?>
                <img src="<?= getTypeIcon($t) ?>" class="type-icon" alt="<?= $t ?>"> <?= ucfirst($t) ?>&nbsp;&nbsp;
            <?php endforeach; ?>
        </p>
    </div>

    <div class="section">
        <h2>Habilidades</h2>
        <p><?= implode(", ", $abilities) ?></p>
    </div>

    <div class="section">
        <h2>Estadísticas Base</h2>
        <div class="stats-grid">
            <?php foreach($stats as $s): ?>
                <div><strong><?= ucfirst($s['stat']['name']) ?>:</strong> <?= $s['base_stat'] ?></div>
            <?php endforeach; ?>
        </div>
    </div>

    <a class="back-btn" href="index.php">← Volver</a>

</div>
</body>
</html>
