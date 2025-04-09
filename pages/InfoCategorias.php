<?php
include("../includes/header.php");
$champ_tags=$_REQUEST['tags'];
//for
?>
<div class="filtros-categorias">
<a class="main-buttons" href="../pages/categorias.php?champ_tags=Mage" >Magos</a>
<a class="main-buttons" href="../pages/categorias.php?champ_tags=Assassin" >Asesinos</a>
<a class="main-buttons" href="../pages/categorias.php?champ_tags=Tank" >Tanques</a>
<a class="main-buttons" href="../pages/categorias.php?champ_tags=Fighter" >Luchadores</a>
<a class="main-buttons" href="../pages/categorias.php?champ_tags=Marksman" >AD Carrys</a>
<a class="main-buttons" href="../pages/categorias.php?champ_tags=Support" >Soportes</a>
</div>
<?php
include("../includes/footer.php");
?>