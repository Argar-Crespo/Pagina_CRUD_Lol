<?php
include("../includes/header.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Conexión a la base de datos
$db = new SQLite3("../db/databaseLol.db");

$id = $_GET['champ_id'] ?? '';
$campeon = null;

// Intentar cargar desde base de datos local
$stmt = $db->prepare("SELECT * FROM campeones WHERE id = :id");
$stmt->bindValue(':id', $id);
$result = $stmt->execute();
$campeon = $result->fetchArray(SQLITE3_ASSOC);

if ($campeon) {
    // Mostrar campeón desde base de datos
    echo '<div id="champion-detail-box">';
    echo '<div class="champion-image">';
    echo "<img src='../{$campeon['imagen']}' alt='{$campeon['nombre']}'>";
    echo '</div>';
    echo "<p class='champion-name'>{$campeon['nombre']}</p>";
    echo "<p class='champion-title'>" . ucwords(strtolower($campeon['titulo'])) . "</p>";
    echo "<div class='champion-info-bar'>";
    $estadisticas = ["ataque" => $campeon['ataque'], "defensa" => $campeon['defensa'], "magia" => $campeon['magia'], "dificultad" => $campeon['dificultad']];
    foreach ($estadisticas as $nombre => $valor) {
        $porcentaje = ($valor / 10) * 100;
        echo "<div class='info-bar-label'>" . ucfirst($nombre) . " ($valor)</div>";
        echo "<div class='info-bar'><div class='info-bar-fill' style='width: {$porcentaje}%;'></div></div>";
    }
    echo "<div class='rol-class'><p class='p-rol'>Rol: {$campeon['rol1']}</p></div>";
    echo '</div>';
    echo '</div>';

} else {
    // Si no está en BD, intenta mostrarlo desde la API
    $url = "http://ddragon.leagueoflegends.com/cdn/15.7.1/data/es_ES/champion.json";
    $response = file_get_contents($url);
    $dato = json_decode($response, true);

    if (isset($dato['data'][$id])) {
        $champ = $dato['data'][$id];

        echo '<div id="champion-detail-box">';
        echo '<div class="champion-image">';
        echo "<img src='https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/{$champ['id']}.png'>";
        echo '</div>';
        echo "<p class='champion-name'>{$champ['name']}</p>";
        echo "<p class='champion-title'>" . ucwords(strtolower($champ['title'])) . "</p>";
        echo "<p class='champion-blurb'>{$champ['blurb']}</p>";

        $estadisticas = ["attack", "defense", "magic", "difficulty"];
        echo "<div class='champion-info-bar'>";
        foreach ($estadisticas as $stat) {
            $valor = $champ['info'][$stat];
            $porcentaje = ($valor / 10) * 100;
            echo "<div class='info-bar-label'>" . ucfirst($stat) . " ($valor)</div>";
            echo "<div class='info-bar'><div class='info-bar-fill' style='width: {$porcentaje}%;'></div></div>";
        }
        echo "<div class='rol-class'><p class='p-rol'>Rol: {$champ['tags'][0]}</p></div>";
        echo "</div>";
        echo "</div>";

    } else {
        echo "<p style='color: red;'> Campeón no encontrado ni en la base de datos ni en la API.</p>";
    }
}

include("../includes/footer.php");
?>
