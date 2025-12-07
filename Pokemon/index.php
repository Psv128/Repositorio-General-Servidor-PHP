<?php

// Mapeo regiones → pokedex
$regionDex = [
    'kanto' => 2,
    'johto' => 7,
    'hoenn' => 15,
    'sinnoh' => 6,
    'unova' => 8,
    'kalos' => 12,
    'alola' => 16,
    'galar' => 27,
    'paldea' => 31
];

$region = $_GET['region'] ?? null;
$page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$batch  = 18;
$pokemonList = [];

if ($region && isset($regionDex[$region])) {
    $dexId = $regionDex[$region];
    $json = @file_get_contents("https://pokeapi.co/api/v2/pokedex/$dexId");
    if ($json !== false) {
        $data = json_decode($json, true);
        $pokemonList = $data['pokemon_entries'] ?? [];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Pokémon</title>
<link rel="stylesheet" href="examen.css" />
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}
body {
    display: flex;
    flex-direction: column;
    background: linear-gradient(180deg,#004f9e,#6cb4ff);
}

main {
    flex: 1;
    width: 100%;
    padding-bottom: 60px;
}


div {
    background: transparent !important;
    border: none !important;
    height: auto !important;
    width: auto !important;
}

/* Grid Pokémon */
#pokemon-grid {
    width: 85%;
    margin: 40px auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 25px;
    padding: 20px;
    background: transparent;
}

.pokemon-card {
    display: block;
    text-align: center;
    background: rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 15px;
    text-decoration: none;
    color: black;
    box-shadow: 0 8px 18px rgba(0,0,0,0.3);
}

.pokemon-card img {
    width: 130px;
    height: 130px;
}

.pagination {
    text-align: center;
    margin: 20px 0 60px 0;
}
.pagination a {
    background: #ffcc66;
    padding: 10px 25px;
    border-radius: 14px;
    font-weight: bold;
    color: #002b5c;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
}
</style>
</head>
<body>

<header>Mi blog de&nbsp;&nbsp;<img src="img/International_Pokémon_logo.svg.png"></header>

<nav>
<strong>
<a href="?region=kanto">Kanto</a>&nbsp;&nbsp;
<a href="?region=johto">Johto</a>&nbsp;&nbsp;
<a href="?region=hoenn">Hoenn</a>&nbsp;&nbsp;
<a href="?region=sinnoh">Sinnoh</a>&nbsp;&nbsp;
<a href="?region=unova">Unova</a>&nbsp;&nbsp;
<a href="?region=kalos">Kalos</a>&nbsp;&nbsp;
<a href="?region=alola">Alola</a>&nbsp;&nbsp;
<a href="?region=galar">Galar</a>&nbsp;&nbsp;
<a href="?region=paldea">Paldea</a>
</strong>
</nav>

<main>
<?php if ($region): ?>
<h2 style="text-align:center; color:white; text-shadow:0 0 6px black; margin-top:25px;">
    Región: <?= ucfirst($region) ?>
</h2>
<?php endif; ?>

<div id="pokemon-grid">
<?php
if ($pokemonList) {
    $start = ($page - 1) * $batch;
    $slice = array_slice($pokemonList, $start, $batch);

    foreach ($slice as $entry) {
        $url = str_replace("pokemon-species", "pokemon", $entry['pokemon_species']['url']);
        $pjson = @file_get_contents($url);
        if ($pjson === false) continue;
        $poke = json_decode($pjson, true);
        if (!$poke) continue;

        echo "<a href='detalles.php?id={$poke['id']}' target='_blank' class='pokemon-card'>";
        echo "<h3>" . strtoupper(htmlspecialchars($poke['name'])) . "</h3>";
        echo "<img src='" . htmlspecialchars($poke['sprites']['front_default']) . "' alt=''>";
        echo "</a>";
    }
}
?>
</div>

<?php if ($region): ?>
<div class="pagination">
<?php if ($start + $batch < count($pokemonList)): ?>
    <a href="?region=<?= $region ?>&page=<?= $page + 1 ?>">Siguiente ➜</a>
<?php endif; ?>
</div>
<?php endif; ?>

</main>

<footer>
Trabajo <strong>Desarrollo Web en Entorno Servidor</strong> 2023/2024 IES Serra Perenxisa.
</footer>
</body>
</html>

