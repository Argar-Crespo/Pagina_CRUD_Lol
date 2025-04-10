<?php
include("includes/header.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="intro">
    <h1>Bienvenido a la Enciclopedia de Campeones de LoL</h1>
    <p>Explora estadísticas, habilidades y curiosidades de todos los campeones del League of Legends. ¡Aprende más sobre tus mains o descubre nuevos favoritos!</p>
</div>

<!-- Botones principales -->
<div class="botonDestacados">
    <a href="/pages/champs.php" class="fancy-btn">🛡️ Todos los campeones</a>
    <a href="/pages/InfoCategorias.php" class="fancy-btn">⚔️ Categorías de campeones</a>
    <a href="/pages/crearChamps.php" class="fancy-btn">⚔️ Crear campeones</a>
</div>

<?php 
    $db = new SQLite3('db/databaseLol.db');

    $resultats = $db->query("SELECT * FROM campeones");
    
    echo '<div class="campeones-ordenar">'; // Contenedor principal

    $resultado = $db->query("SELECT * FROM campeones ORDER BY RANDOM() LIMIT 1");
    $campeonAleatorio = $resultado->fetchArray(SQLITE3_ASSOC);

    $result = $db->querySingle("SELECT COUNT(*) FROM campeones");
    $total = (int)$result;

    $randomOffset = rand(0, $total - 1);

    $stmt = $db->prepare("SELECT * FROM campeones LIMIT 1 OFFSET :offset");
    $stmt->bindValue(':offset', $randomOffset, SQLITE3_INTEGER);
    $champ = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    
    while ($fila = $resultats->fetchArray(SQLITE3_ASSOC)) {
        echo  "<a href='pages/infoChamps.php?champ_id=".$fila['id']."' class='category-link'>".$fila['nombre']."</a>";
        if (!empty($fila['imagen'])) { // Mostrar imagen si existe
            echo "<a href='pages/infoChamps.php?champ_id=".$fila['id']."' class='category-link'><img src='" . htmlspecialchars($fila['imagen']) . "' class='category-image'>"."</a>";
        }
        echo "<br>";
    }

    ?>
    <div class="random-champ">
    <h2>⭐ Campeón destacado</h2>
    <a class="linksHyp" href="/pages/infoChamps.php?champ_id=<?php echo $campeonAleatorio['id']; ?>">
        <img src="<?php echo $campeonAleatorio['imagen']; ?>" alt="<?php echo $campeonAleatorio['nombre']; ?>">
        <p><?php echo $campeonAleatorio['nombre']; ?> - <?php echo ucwords(strtolower($campeonAleatorio['titulo'])); ?></p>
    </a>
</div>

<?php
echo '<div class="champ-gallery"><div class="popular-champs">';
for ($i = 0; $i < 5; $i++) {
    $resultado5 = $db->query("SELECT * FROM campeones ORDER BY RANDOM() LIMIT 1");
    $campeonAleatorio5 = $resultado5->fetchArray(SQLITE3_ASSOC);
    ?>
    <a class="linksHyp" href="/pages/infoChamps.php?champ_id=<?php echo $campeonAleatorio5['id']; ?>">
        <img src="<?php echo $campeonAleatorio5['imagen']; ?>" alt="<?php echo $campeonAleatorio5['nombre']; ?>">
    </a>
    <?php
}
echo '</div></div>';

    $db->close();
    ?>


<!-- Créditos -->
<div class="creditos">
    <p>⚙️ Proyecto hecho por <strong>Los Pingas</strong> para practicar desarrollo web. Todos los datos provienen de Riot Games (API oficial).</p>
    <a href="db/databaseInit.php">Borrar Base de Datos</a>
</div>

<?php include("includes/footer.php"); ?>
