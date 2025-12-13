<?php
/* Versión revisada completamente
   - Gradiente continuo en TODA la página (solo aplicado en body)
   - Eliminadas líneas blancas (divs fantasmas y backgrounds heredados)
   - Footer SIEMPRE empujado hacia abajo
   - Pokémon bien distribuidos y nunca solapados
   - Botón “Siguiente” SIEMPRE visible y debajo del grid
   - detalles.php rediseñado completamente para evitar solapamientos
   - Sin JS (solo PHP + HTML + CSS)
*/

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

/* Eliminar TODAS las líneas blancas generadas por divs genéricos */
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

<!-- Search / Filter form -->
<nav style="margin-top:12px;">
    <form method="get" action="index.php" id="search-form" style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;">
        <input type="text" name="q" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" style="padding:8px;border-radius:8px;border:1px solid rgba(0,0,0,0.15);width:240px;" />
        <select name="type" style="padding:8px;border-radius:8px;border:1px solid rgba(0,0,0,0.15);">
            <option value="any">-- Tipo (todos) --</option>
            <?php
            $typesList = ["water","fire","ice","steel","bug","grass","dark","psychic","fairy","ground","rock","poison","electric","fighting","flying","dragon","ghost","normal"];
            $selectedType = $_GET['type'] ?? 'any';
            foreach($typesList as $t) {
                $sel = ($selectedType === $t) ? 'selected' : '';
                echo "<option value=\"$t\" $sel>" . ucfirst($t) . "</option>";
            }
            ?>
        </select>
        <select name="region" style="padding:8px;border-radius:8px;border:1px solid rgba(0,0,0,0.15);">
            <option value="">-- Región (todas) --</option>
            <?php
            $regions = array_keys($regionDex);
            $selRegion = $_GET['region'] ?? '';
            foreach($regions as $r) {
                $sel = ($selRegion === $r) ? 'selected' : '';
                echo "<option value=\"$r\" $sel>" . ucfirst($r) . "</option>";
            }
            ?>
        </select>
        <button type="submit" style="padding:8px 14px;border-radius:10px;background:#ffcc66;border:none;font-weight:bold;">Buscar</button>
    </form>
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
    // Filters from form
    $q = strtolower(trim($_GET['q'] ?? ''));
    $typeFilter = $_GET['type'] ?? 'any';

    // Build filtered list (will fetch details only when necessary)
    $filtered = [];
    foreach ($pokemonList as $entry) {
        $speciesName = strtolower($entry['pokemon_species']['name'] ?? '');

        // Name filter
        if ($q !== '' && strpos($speciesName, $q) === false) {
            continue;
        }

        // Type filter: need to fetch pokemon detail to check types
        if ($typeFilter !== 'any') {
            $url = str_replace("pokemon-species", "pokemon", $entry['pokemon_species']['url']);
            $pjson = @file_get_contents($url);
            if ($pjson === false) continue;
            $poke = json_decode($pjson, true);
            if (!$poke) continue;

            $typesNames = array_map(fn($t) => $t['type']['name'], $poke['types']);
            if (!in_array($typeFilter, $typesNames, true)) {
                continue;
            }

            // store detail to avoid refetching later
            $entry['_poke'] = $poke;
        }

        $filtered[] = $entry;
    }

    // Pagination on filtered list
    $start = ($page - 1) * $batch;
    $slice = array_slice($filtered, $start, $batch);

    foreach ($slice as $entry) {
        if (isset($entry['_poke'])) {
            $poke = $entry['_poke'];
        } else {
            $url = str_replace("pokemon-species", "pokemon", $entry['pokemon_species']['url']);
            $pjson = @file_get_contents($url);
            if ($pjson === false) continue;
            $poke = json_decode($pjson, true);
            if (!$poke) continue;
        }

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
<?php
    $totalCount = isset($filtered) ? count($filtered) : count($pokemonList);
    if ($start + $batch < $totalCount):
        $qs = [];
        if ($region) $qs['region'] = $region;
        if (!empty($_GET['q'])) $qs['q'] = $_GET['q'];
        if (!empty($_GET['type']) && $_GET['type'] !== 'any') $qs['type'] = $_GET['type'];
        $qs['page'] = $page + 1;
        $query = http_build_query($qs);
?>
    <a href="?<?= $query ?>">Siguiente ➜</a>
<?php endif; ?>
</div>
<?php endif; ?>

</main>

<footer>
Trabajo <strong>Desarrollo Web en Entorno Servidor</strong> 2023/2024 IES Serra Perenxisa.
</footer>
</body>
</html>
