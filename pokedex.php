<?php
//Fraser Provan 22/06/2018
//Pokedex home page

//connects to database
$conn = new PDO("mysql:host=localhost;dbname=medotusc_pokedex;", "medotusc_fraser", "NHD4?oWU5Bpo");

//gets Pokemonds ID
$pid = $_GET["pid"];

//if pokemonID is false or greater than 151
if (!$pid or $pid > 151) {
    //set pokemon ID to 1 (default: Bulbasaur)
    $pid = '1';
}

//selects all from pokemon using the pokemons ID
$pokemonInfo = $conn->query("SELECT * from pokemon WHERE pid = $pid");
$pokemon     = $pokemonInfo->fetch();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type='text/javascript' src='scripts/main.js'></script>
    <title>Pokédex</title>
</head>

<body>

    <div class="row">
        <div class="col-sm" id="pokedex-area">
            <h1>Gen 1 Pokédex</h1>
        </div>
    </div>

    <div class="container">
        <div id="content-main">

            <!--GoTo Pokemon, Randomly choose one-->
            <div class="row">
                <div class="col-sm">
                    <form id="tools">
                        <input type="text" placeholder="No. (1-151)" id="searchPokemon" name="pid" onkeypress="return isNumberKey(event)">
                        <button type="submit" class="toolsBtn">Go!</button>
                        <input type="button" class="toolsBtn" onclick="randomPokemon()" value="Random"/>
                    </form>

                </div>
            </div>

            <div id="content-main-body">
                <!--Name, Number, Sprite-->
                <div class="row">
                    <div class="col-sm-4">
                        <h4>#<?php echo $pokemon['pid']; ?> <?php echo $pokemon['tname']; ?></h4>
                        <img src="img/sprites/<?php echo $pokemon['pid']; ?>.png" class="sprite">
                        <img src="img/sprites/shiny/<?php echo $pokemon['pid']; ?>.png" class="sprite">
                        <img src="img/sprites/back/<?php echo $pokemon['pid']; ?>.png" class="sprite">
                        <img src="img/sprites/back/shiny/<?php echo $pokemon['pid']; ?>.png" class="sprite">
                    </div>

                    <!--Description-->
                    <div class="col-sm-8">
                        <h6><a style="fontweight:none;">Type 1: </a><?php echo $pokemon['type1']; ?></h6>
                        <h6>Type 2: <?php echo $pokemon['type2']; ?></h6>
                        <h6>Description:</h6>
                    </div>
                </div>
            </div>
        </div>

        <!--List of pokemon-->
        <div id="content-second">
            <h4 class="title">All Pokémon</h4>
            <div class="pokemonList">

        <?php
        // Selects all pokemon
        $pokemonResults = $conn->query("SELECT * from pokemon");
        ?>

        <table class='table table-hover' id='myTable'>
            <thead>
                <tr>
                    <th scope='col' id='table-heading'>Number</th>
                    <th scope='col' id='table-heading'>Name</th>
                    <th scope='col' id='table-heading' class="table-toHide">Type 1</th>
                    <th scope='col' id='table-heading' class="table-toHide">Type 2</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    // Displays pokemon results in table
                    while ($allPokemon = $pokemonResults->fetch()) {
                    $pidAll = $allPokemon['pid'];
                ?>

                <tr>
                    <td>
                        <?php echo $allPokemon['pid']; //Number ?> 
                    </td>
                    <td>
                        <a href='pokedex.php?pid=<?php echo $pidAll; //Name ?>'>
                            <?php echo $allPokemon['tname']; ?>
                        </a>
                    </td>
                    <td class="table-toHide">
                        <?php echo $allPokemon['type1']; //Type 1 ?>
                    </td>
                    <td class="table-toHide">
                        <?php echo $allPokemon['type2']; //Type 2 ?>
                    </td>
                </tr>

                <?php }; //loop ends ?>
            </tbody>
        </table>
        </div>

            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
</body>

</html>