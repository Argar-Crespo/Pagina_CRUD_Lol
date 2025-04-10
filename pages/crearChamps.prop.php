<?php
include("../includes/header.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new SQLite3("../db/databaseLol.db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $titulo = $_POST['titulo'];
    $rol1 = $_POST['rol1'];
    $rol2 = $_POST['rol2'];
    $ataque = $_POST['ataque'];
    $defensa = $_POST['defensa'];
    $magia = $_POST['magia'];
    $dificultad = $_POST['dificultad'];

    //Hecho con chatgpt porque no lo sabemos hacer
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorioDestino = "../img/";
        $nombreOriginal = basename($_FILES['imagen']['name']);
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($extension, $extensionesPermitidas)) {
            $nombreArchivo = uniqid('champ_') . '.' . $extension;
            $rutaFinal = $directorioDestino . $nombreArchivo;
            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal);
            $imagen = "img/" . $nombreArchivo;
        } else {
            echo "<div class='error-message'>Extensión no permitida.</div>";
            exit;
        }
    } else {
        $imagen = "";
    }
//


    $rolesValidos = ['Fighter', 'Mage', 'Assassin', 'Marksman', 'Tank', 'Support'];

    if (!in_array($rol1, $rolesValidos)) {
        echo '<div class="error-message">ERROR: El rol1 no es válido.</div>';
        exit;
    }
    if (!empty($rol2) && !in_array($rol2, $rolesValidos)) {
        echo '<div class="error-message">ERROR: El rol2 no es válido.</div>';
        exit;
    }
    $rol2 = empty($rol2) ? null : $rol2;

    $stmt = $db->prepare("INSERT INTO campeones 
        (id, nombre, titulo, rol1, rol2, ataque, defensa, magia, dificultad, imagen) 
        VALUES 
        (:id, :nombre, :titulo, :rol1, :rol2, :ataque, :defensa, :magia, :dificultad, :imagen)");

    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
    $stmt->bindValue(':titulo', $titulo, SQLITE3_TEXT);
    $stmt->bindValue(':rol1', $rol1, SQLITE3_TEXT);
    $stmt->bindValue(':rol2', $rol2, is_null($rol2) ? SQLITE3_NULL : SQLITE3_TEXT);
    $stmt->bindValue(':ataque', $ataque, SQLITE3_INTEGER);
    $stmt->bindValue(':defensa', $defensa, SQLITE3_INTEGER);
    $stmt->bindValue(':magia', $magia, SQLITE3_INTEGER);
    $stmt->bindValue(':dificultad', $dificultad, SQLITE3_INTEGER);
    $stmt->bindValue(':imagen', $imagen, SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo '<div class="success-message">✅ Campeón agregado correctamente.</div>';
        echo '<a href="../index.php" class="btn-secondary">Regresar</a>';
    } else {
        echo '<div class="error-message">❌ ERROR: No se pudo agregar al Campeón. ' . $db->lastErrorMsg() . '</div>';
        echo '<a href="../index.php" class="btn-secondary">Regresar</a>';
    }
}

include("../includes/footer.php");
?>
