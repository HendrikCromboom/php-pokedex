<?php
declare(strict_types=1);
ini_set("display_errors=1", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

class Pokemon{
   var string $index = "";
   var string $name = "";
   var array $types = [];
   var string $type = "";
   var string $sprites = "";
   var string $front = "";
   var array $moves = [];
   var array $move = [];
   var string $evo = "";
   var string $evoFront= "";
   var string $species = "";
   var string $chain = "";
}

$name = $_POST['pokeNameOrId'];
if($name===null){$name=1;}
$fetch = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$name."/");
$data = json_decode($fetch, true);
$id = $data["id"];

$poke = new Pokemon();
$index = $data["id"];
$name = $data["name"];
echo $index. "\n";
echo $name. "\n";
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