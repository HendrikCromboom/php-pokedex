<?php//Might add OOP again now that I noticed I made a typo... Will do after campus hours
//Start of API calls and data handling
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
    $types[] = $pokeType["type"]["name"];// This is basically the optimal way of pushing to an array in php
$type = join( ", ", $types);// types will always be present, will look into error handling later
$moves = $data["moves"];
$moveCount = count($moves);
for($i = 0; $i < $moveCount && $i<4; $i++)
    $move[] = $moves[rand(1, $moveCount)-1]["move"]["name"];
    array_splice($moves, $i);
$species = $data["species"]["url"];
$chainFetch = file_get_contents($species);
$chainData = json_decode($chainFetch, true);
$color = $chainData["color"]["name"];
$evoFrom = $chainData["evolves_from_species"];
//Start of echoing HTML with inline PHP
echo "<div id='flex'><div class='sweet'><p>$index</p><br>";// Adding some css classes
echo "<p>$name</p><br>";
echo "<p style="."background-color:".$color."><img src=".$front."></p>";
echo "<p>$type</p><br>";
foreach ($move as $thisMove){
    echo "<p>$thisMove</p><br> ";}
echo "</div>";// div ends here
if ($evoFrom!= null){// if the species evolves from isn't empty we execute the following
    $evoName = $evoFrom["name"];
    $thisEvoFetch = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$evoName. "/");
    $thisEvoData = json_decode($thisEvoFetch, true);
    $evoFront = $thisEvoData["sprites"]["front_default"];
    echo "<div class='sweet'><p>$name evolves from:</p><br>";
    echo "<p>$evoName</p><br>";
    echo "<p style="."background-color:".$color."><img src=".$evoFront."></p></div>";}
echo "</div>";//div outside so even IF there are no evo's it gets handled
//Start of HTML form
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokedex</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div>
    <table>
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