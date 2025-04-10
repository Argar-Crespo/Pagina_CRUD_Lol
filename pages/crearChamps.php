<?php 
include("../includes/header.php"); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="form-container">
    <h3>Alta de Nuevo Campeon</h3>
    <form action="crearChamps.prop.php" method="POST" enctype="multipart/form-data">
        <label for="id">Nombre del campeon para la id:</label>
        <input type="text" name="id" id="id" required>
        <label for="nombre">Nombre del campeon:</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="titulo">Dale un titulo al campeon:</label>
        <textarea type="text" name="titulo" id="titulo" required></textarea>
        <label for="rol1">Rol principal:</label>
        <select name="rol1" id="rol1" required>
            <option value="Fighter">Fighter</option>
            <option value="Mage">Mage</option>
            <option value="Assassin">Assassin</option>
            <option value="Marksman">Marksman</option>
            <option value="Tank">Tank</option>
            <option value="Support">Support</option>
        </select>
        <label for="rol2">Rol secundario (opcional):</label>
        <select name="rol2" id="rol2">
            <option value="">-- Ninguno --</option>
            <option value="Fighter">Fighter</option>
            <option value="Mage">Mage</option>
            <option value="Assassin">Assassin</option>
            <option value="Marksman">Marksman</option>
            <option value="Tank">Tank</option>
            <option value="Support">Support</option>
        </select>
        <label for="ataque">Cuanto ataque tiene tu campeon(0-10):</label>
        <input type="number" min="0" max="10" name="ataque" id="ataque" required>
        <label for="defensa">Cuanta defensa tiene tu campeon(0-10):</label>
        <input type="number" min="0" max="10" name="defensa" id="defensa" required>
        <label for="magia">Cuanta magia tiene tu campeon(0-10):</label>
        <input type="number" min="0" max="10" name="magia" id="magia" required>
        <label for="dificultad">Cuanta dificultad tiene tu campeon:(0-10)</label>
        <input type="number" min="0" max="10" name="dificultad" id="dificultad" required>
        <label for="imagen">Sube una imagen de tu campeon(Opcional):</label>
  <input type="file" name="imagen" id="imagen" accept="image/*">

        <input type="submit" value="Agregar Campeon" class="btn-primary">
    </form>
</div>

<?php include("../includes/footer.html"); ?>