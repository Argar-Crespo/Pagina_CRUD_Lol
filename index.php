<?php
include("includes/header.php");

$url = "http://ddragon.leagueoflegends.com/cdn/15.7.1/data/es_ES/champion.json";
$response = file_get_contents($url);
$dato = json_decode($response, true);

$randomKey = array_rand($dato['data']);
$randomChamp = $dato['data'][$randomKey];
?>

<div class="intro">
    <h1>Bienvenido a la Enciclopedia de Campeones de LoL</h1>
    <p>Explora estadísticas, habilidades y curiosidades de todos los campeones del League of Legends. ¡Aprende más sobre tus mains o descubre nuevos favoritos!</p>
</div>

<!-- Botones principales -->
<div class="botonDestacados">
    <a href="/pages/champs.php" class="fancy-btn">🛡️ Todos los campeones</a>
    <a href="/pages/InfoCategorias.php" class="fancy-btn">⚔️ Categorías de campeones</a>
</div>

<!-- Campeón destacado -->
<div class="random-champ">
    <h2>⭐ Campeón destacado</h2>
    <a class="linksHyp" href="/pages/infoChamps.php?champ_id=<?php echo $randomChamp['id']; ?>">
        <img src="https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/<?php echo $randomChamp['id']; ?>.png" alt="<?php echo $randomChamp['name']; ?>">
        <p><?php echo $randomChamp['name']; ?> - <?php echo ucwords(strtolower($randomChamp['title'])); ?></p>
    </a>
</div>

<!-- Galería rápida -->
<!-- Galería rápida -->
<div class="champ-gallery">
    <h2>🖼 Campeones populares</h2>
    <div class="popular-champs">
        <?php
        for($i = 0; $i < 6; $i++) {
            $randomKey2 = array_rand($dato['data']);
            $randomChamp2 = $dato['data'][$randomKey2];
            echo "<a href='/pages/infoChamps.php?champ_id={$randomChamp2['id']}'>";
            echo "<img src='https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/{$randomChamp2['id']}.png' title='{$randomChamp2['name']}' alt='{$randomChamp2['name']}'>";
            echo "</a>";
        }
        ?>
    </div>
</div>


<!-- Créditos -->
<div class="creditos">
    <p>⚙️ Proyecto hecho por <strong>Los Pingas</strong> para practicar desarrollo web. Todos los datos provienen de Riot Games (API oficial).</p>
</div>

<?php include("includes/footer.php"); ?>
