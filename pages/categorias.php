<?php
include("../includes/header.php");
$url="http://ddragon.leagueoflegends.com/cdn/15.7.1/data/es_ES/champion.json";
$response = file_get_contents($url);
$dato = json_decode($response, true);
$champ_tags = $_REQUEST['champ_tags'];
?>
<div class="">
<?php
if ($dato && isset($dato['data']) && is_array($dato['data'])) {
    echo '<div id="campeonesBox">'; 
    
    foreach ($dato['data'] as $campeon) {
        if ($campeon['tags'][0]==$champ_tags){
        echo "<div class='campeon'>"; 
        echo "<div class='imgChamp'>";
        echo "<a href='/pages/infoChamps.php?champ_id=" . $campeon['id'] . "'>
                  <img id='fotosTeticaVieja' src='https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/" . $campeon['id'] . ".png'>
              </a>";
        echo "</div>";
        echo "<p>" . $campeon['name'] . "<br>" . ucwords(strtolower($campeon['title'])) . "</p>";
        echo "</div>"; 
    }
}

    echo '</div>'; 
    
}else{
    echo"Error pa esta ping@";
}
?>

<?php
include("../includes/footer.php");
?>