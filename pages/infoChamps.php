<?php
include("../includes/header.php");

// Cargar los datos del JSON de campeones
$url = "http://ddragon.leagueoflegends.com/cdn/15.7.1/data/es_ES/champion.json";
$response = file_get_contents($url);
$dato = json_decode($response, true);

// Estadísticas clave y detalladas
$estadisticas = ["attack", "defense", "magic", "difficulty"];
$stats = ["hp", "hpperlevel", "mp", "mpperlevel", "movespeed", "armor", "armorperlevel",
          "spellblock", "spellblockperlevel", "attackrange", "hpregen", "hpregenperlevel",
          "mpregen", "mpregenperlevel", "crit", "critperlevel", "attackdamage",
          "attackdamageperlevel", "attackspeedperlevel", "attackspeed"];

// Obtener el ID del campeón actual
$campeonActual = $_GET['champ_id'];
$campeones = array_keys($dato['data']);
$posicion = array_search($campeonActual, $campeones);
$anterior = ($posicion > 0) ? $campeones[$posicion - 1] : null;
$siguiente = ($posicion < count($campeones) - 1) ? $campeones[$posicion + 1] : null;
?>

<!-- Navegación entre campeones -->
<div class="champion-nav">
    <?php if ($anterior): ?>
        <a href="/pages/infoChamps.php?champ_id=<?= $anterior ?>">
            <button class="champion-nav-btn">← Anterior</button>
        </a>
    <?php else: ?>
        <button class="champion-nav-btn disabled" disabled>← Anterior</button>
    <?php endif; ?>

    <?php if ($siguiente): ?>
        <a href="/pages/infoChamps.php?champ_id=<?= $siguiente ?>">
            <button class="champion-nav-btn">Siguiente →</button>
        </a>
    <?php else: ?>
        <button class="champion-nav-btn disabled" disabled>Siguiente →</button>
    <?php endif; ?>
</div>

<?php
if ($dato && isset($dato['data'][$campeonActual])) {
    $campeon = $dato['data'][$campeonActual];

    echo '<div id="champion-detail-box">';

    // Imagen
    echo '<div class="champion-image">';
    echo '<img src="https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/' . $campeon['id'] . '.png" alt="' . $campeon['name'] . '">';
    echo '</div>';

    // Nombre y título
    echo '<p class="champion-name">' . $campeon['name'] . '</p>';
    echo '<p class="champion-title">' . ucwords(strtolower($campeon['title'])) . '</p>';

    // Descripción
    echo '<p class="champion-blurb">' . $campeon['blurb'] . '</p>';

    // Info general con barras
    echo '<p class="champion-section-title">Información del campeón</p>';
    echo '<div class="champion-info-bar">';
    foreach ($estadisticas as $stat) {
        $valor = $campeon['info'][$stat];
        $porcentaje = ($valor / 10) * 100;
        echo "<div class='info-bar-label'>" . ucfirst($stat) . " ($valor)</div>";
        echo "<div class='info-bar'><div class='info-bar-fill' style='width: {$porcentaje}%;'></div></div>";
    }
    echo "<div class='rol-class'><p class='p-rol'>Rol: " . $campeon['tags'][0] . "</p></div>";
    echo '</div>';

    // Estadísticas detalladas
    echo '<p class="champion-section-title">Estadísticas detalladas</p>';
    echo '<div class="champion-stats">';
    foreach ($stats as $stat) {
        echo "<div class='champion-stat-line'><span>" . ucfirst($stat) . ":</span> <span>" . $campeon['stats'][$stat] . "</span></div>";
    }
    echo '</div>';

    echo '</div>'; // cierre de #champion-detail-box
} else {
    echo "<p style='color: red;'>❌ Error al cargar los datos del campeón.</p>";
}
?>

<?php include("../includes/footer.php"); ?>
