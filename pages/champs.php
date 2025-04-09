<?php
include("../includes/header.php");
$url="http://ddragon.leagueoflegends.com/cdn/15.7.1/data/es_ES/champion.json";
$response = file_get_contents($url);
$dato = json_decode($response, true);
?>
<div class="">
<?php
$estadisticas =["attack","defense","magic","difficulty"];
$stats =["hp",
        "hpperlevel",
        "mp",
        "mpperlevel",
        "movespeed",
        "armor",
        "armorperlevel",
        "spellblock",
        "spellblockperlevel",
        "attackrange",
        "hpregen",
        "hpregenperlevel",
        "mpregen",
        "mpregenperlevel",
        "crit",
        "critperlevel",
        "attackdamage",
        "attackdamageperlevel",
        "attackspeedperlevel",
        "attackspeed"];
if ($dato && isset($dato['data']) && is_array($dato['data'])) {
    echo '<div id="campeonesBox">'; 

    foreach ($dato['data'] as $campeon) {
        echo "<div class='campeon'>"; 
        echo "<div class='imgChamp'>";
        echo "<a href='/pages/infoChamps.php?champ_id=" . $campeon['id'] . "'>
                  <img id='fotosTeticaVieja' src='https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/" . $campeon['id'] . ".png'>
              </a>";
        echo "</div>";
        echo "<p>" . $campeon['name'] . "<br>" . ucwords(strtolower($campeon['title'])) . "</p>";
        echo "</div>";
    }
    
    echo '</div>'; 
    
}else{
    echo"Error pa esta ping@";
}
?>
<p>El boton de regresar el nombre de la web :)</p>
<?php
include("../includes/footer.php");
?>