<?php
declare(strict_types=1);
ini_set("display_errors=1", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);


$name = $_POST['pokeNameOrId'];
if($name===null){$name=1;}
$fetch = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$name."/");
$data = json_decode($fetch, true);
$index = $data["id"];
$name = $data["name"];
$pokeTypes = $data["types"];
$sprites = $data["sprites"];
$front = $sprites["front_default"];
foreach ($pokeTypes as $pokeType)
    $types[] = $pokeType["type"]["name"];
$type = join( ", ", $types);
$moves = $data["moves"];
$moveCount = count($moves);
for($i = 0; $i <= $moveCount && $i<4; $i++)
    $move[] = $moves[rand(1, $moveCount)]["move"]["name"];
    array_splice($moves, $i);
$species = $data["species"]["url"];
$chainFetch = file_get_contents($species);
$chainData = json_decode($chainFetch, true);
$chain = $chainData["evolution_chain"]["url"];
$evoFetch = file_get_contents($chain);
$evoData = json_decode($evoFetch, true);
$base= $evoData["chain"];
$countEvo = count($base["evolves_to"]);
$evolutions = array();
$countEvo>1?getDemEvos($countEvo, $base):getOneEvo($base);
function getDemEvos($countEvo, $base){
    for($i=0; $i<$countEvo;$i++){array_push($evolutions, $base["evolves_to"][$i]["species"]["name"]);}
    return $evolutions;
}
function getOneEvo($base){
    array_push($evolutions, $base["species"]["name"]);
}
echo $evolutions;
//$evoName  = $evoData["chain"]["evolves_to"][0]["species"]["name"];
//$thisEvoFetch = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$evoName. "/");
//$thisEvoData = json_decode($thisEvoFetch, true);
//$evoFront = $thisEvoData["sprites"]["front_default"];

echo "<p>$index</p><br>";
echo "<p>$name</p><br>";
echo "<p>$type</p><br>";
echo "<img src=".$front.">";
foreach ($move as $thisMove)
    echo "<p>$thisMove</p><br>";
//echo "<img src=".$evoFront.">";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokedex</title>
</head>
<body>
<div class="grid-container">
    <table class="tablo">
        <tr>
            <td>
                <form autocomplete="off" action="index.php" method="post">
                    <div>
                        <label>Name or ID
                            <br>
                            <input type="text" name="pokeNameOrId" alt="Insert Name or ID of Pokemon" id="pokeNameOrId">
                        </label>
                    </div>

                    <label>
                        <br>
                        <input type="submit" value="Submit" class="button">
                    </label>
                </form>
            </td>
    </table>
</div>