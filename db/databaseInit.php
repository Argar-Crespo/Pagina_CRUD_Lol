<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_path = "databaseLol.db";
if (file_exists($db_path)) {
    unlink($db_path);
    echo "✅ Base de datos eliminada<br>";
}

$db = new SQLite3('databaseLol.db');


$db->exec("CREATE TABLE IF NOT EXISTS campeones (
    id TEXT PRIMARY KEY,
    nombre TEXT NOT NULL,
    titulo TEXT NOT NULL,
    rol1 TEXT NOT NULL CHECK(rol1 IN ('Fighter', 'Mage', 'Assassin', 'Marksman', 'Tank', 'Support')),
    rol2 TEXT CHECK(rol2 IN ('Fighter', 'Mage', 'Assassin', 'Marksman', 'Tank', 'Support')),
    ataque INTEGER NOT NULL,
    defensa INTEGER NOT NULL,
    magia INTEGER NOT NULL,
    dificultad INTEGER NOT NULL,
    imagen TEXT
);");


// Cargo los datos de la api en sus respectivos valores para luego insertarlo dentro de la base de datos
$url = "https://ddragon.leagueoflegends.com/cdn/15.7.1/data/es_ES/champion.json";
$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data && isset($data['data'])) {
    $champions = $data['data'];

    foreach ($champions as $champ) {
        $id = $champ['id'];
        $nombre = $champ['name'];
        $titulo = $champ['title'];
        $valoresPermitidos = ['Fighter', 'Mage', 'Assassin', 'Marksman', 'Tank', 'Support'];
        $rol1 = (isset($champ['tags'][0]) && in_array($champ['tags'][0], $valoresPermitidos)) ? $champ['tags'][0] : 'Fighter';
        $rol2 = (isset($champ['tags'][1]) && in_array($champ['tags'][1], $valoresPermitidos)) ? $champ['tags'][1] : null;
        $ataque = $champ['info']['attack'];
        $defensa = $champ['info']['defense'];
        $magia = $champ['info']['magic'];
        $dificultad = $champ['info']['difficulty'];
        $imagen = "https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/{$id}.png";

        // Se insertan los datos en los campos de la tabla
        $stmt = $db->prepare("INSERT INTO campeones (id, nombre, titulo, rol1, rol2, ataque, defensa, magia, dificultad, imagen) 
                              VALUES (:id, :nombre, :titulo, :rol1, :rol2, :ataque, :defensa, :magia, :dificultad, :imagen)");
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':rol1', $rol1);
        $stmt->bindValue(':rol2', $rol2, is_null($rol2) ? SQLITE3_NULL : SQLITE3_TEXT);
        $stmt->bindValue(':ataque', $ataque, SQLITE3_INTEGER);
        $stmt->bindValue(':defensa', $defensa, SQLITE3_INTEGER);
        $stmt->bindValue(':magia', $magia, SQLITE3_INTEGER);
        $stmt->bindValue(':dificultad', $dificultad, SQLITE3_INTEGER);
        $stmt->bindValue(':imagen', $imagen);
        $stmt->execute();
    }

    echo "Todos los campeones han sido insertados correctamente.<br>";
} else {
    echo "Error al cargar la API.";
}

echo '<a href="../index.php">Regresar</a>';
?>
