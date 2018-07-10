<?php
//Fraser Provan 22/06/2018
//Pokedex home page

//connects to database
$conn = new PDO("mysql:host=localhost;dbname=medotusc_pokedex;", "medotusc_fraser", "NHD4?oWU5Bpo");

//generates random number between 1 and 100 (Shiny Chances)
$randomNumber = rand(1, 25);

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/types.css">
    <script type='text/javascript' src='scripts/main.js'></script>
    <title>Pokédex</title>
</head>

<body style="background-image: url('img/pixel_weave.png');">
    <div class="container">
        <div id="main-body">
            
            <!--Row 1-->
            <div class="row">
                <!--Title-->
                <div class="col-sm" id="top">
                    <h2 class="title">Pokédex</h2>
                </div>
            </div>

            <!--Row 2-->
            <div class="row">
                
                <!--Pokemon Info-->
                <div class="col-sm-5" id="left">

                    <!--Previous and Next-->
                    <?php
                        $previous = $pokemon['pid'] - 1; //prepares varaible for previus
                        $next     = $pokemon['pid'] + 1; //prepares varaible for next
                    ?>

                    <div id="tools" class="row">

                        <!--Previous-->
                        <?php 
                            if ($pokemon['pid'] > 1) { 
                                ?>
                                <a class="col-2 next-previous" href='pokedex.php?pid=<?php echo $previous; ?>'>←<?php echo $previous; ?></a>
                       
                       <?php //previous link
                            } else {
                                //echo blank with col to keep column sizes
                                echo "<a class='col-2'></a>";
                            }
                        ?>

                        <!--Secret Number (Shiny value) -->
                        <div class="col"></div>

                        <!--Next-->
                        <?php
                            //only shows next link if pid is less than 151
                            if ($pokemon['pid'] < 151) {
                                ?>
                                <a class="col-2 next-previous" href='pokedex.php?pid=<?php echo $next; ?>'> <?php echo $next; ?>→</a>
                        
                        <?php //Next link 
                            } else {
                                //echo blank with col to keep column sizes
                                echo "<a class='col-2'></a>";
                            }
                        ?>

                    </div>

                    <!--Pokemon Name-->
                    <?php
                    //sees if secretNumber is shiny
                    //if yes show shiney Name
                    if ($randomNumber === 1) {
                        ?>
                            <div class="row">
                                <h4 class="pokemonName col" style="color:#6200EA;">
                                    <a style="color:#E53935;font-weight:bold;">#</a><?php echo $pokemon['pid']; ?> <?php echo $pokemon['tname']; ?>
                                </h4>
                            </div>
                        <?php
                    
                    //else show normal name
                    } else {
                        ?>
                            <div class="row">
                                <h4 class="pokemonName col">
                                    <a style="color:#E53935;font-weight:bold;">#</a><?php echo $pokemon['pid']; ?> <?php echo $pokemon['tname']; ?>
                                </h4>
                            </div>
                        <?php } ?>

                    <!--Pokemon Images-->
                    <?php
                        //if randomNumber is 1 (/50) use shiny sprites
                        if ($randomNumber === 1) {
                            echo "<img src='img/sprites/shiny/" . $pokemon['pid'] . ".png' class='sprite'>";
                            echo "<img src='img/sprites/back/shiny/" . $pokemon['pid'] . ".png' class='sprite'>";
                        }

                        //otherwise use regular
                        else {
                            echo "<img src='img/sprites/" . $pokemon['pid'] . ".png' class='sprite'>";
                            echo "<img src='img/sprites/back/" . $pokemon['pid'] . ".png' class='sprite'>";
                        }

                        //unsets variable after used
                        unset($randomid);
                    
                        //Pokemons Types
                        //finds types and puts them into new variables
                        include 'include/typeFinder.php';

                        //if theres no type 2 only show type 1
                        if (!$pokemon['type2']) {
                    ?>
                    
                    <h6>
                        <?php echo $typeOneFound; ?>
                        <a class="type">
                    </h6>
                    </a>

                    <?php 
                    }
                    //otherwise show both type 1 and 2
                     else {
                    ?>
                        <h6>
                            <?php echo $typeOneFound; ?>
                            <a class="type"></a>
                            <a class="type"></a>
                            <?php echo $typeTwoFound; ?>
                        </h6>
                    <?php } ?>
                    
                    <!--Pokemons Description-->
                    <p>
                        <a style='font-weight:bold;'>Description: </a>
                        <?php echo $pokemon['description']; ?>
                    </p>
                    
                    <?php echo "<p class='secretNumber'>" . $randomNumber . "</p>"; //Shiney indicator at bottom of info box  ?>
                    
                </div>

                <!--Tools-->
                <div class="col-sm-7" id="right">
                    <div class="form-group row">
                        <input type="text" class="searchPokemonName col" placeholder="Search Name" onkeyup="searchPokemon()" id="myInput">
                        <select class="1-100 col searchPokemonType" placeholder="1-151" id="myInputType" name="pid" onclick="searchType()" placeholder="1"
                            value="1">
                            <option value="">Sort Type</option>
                            <option value="Bug">Bug</option>
                            <option value="Dragon">Dragon</option>
                            <option value="Ice">Ice</option>
                            <option value="Fighting">Fighting</option>
                            <option value="Fire">Fire</option>
                            <option value="Flying">Flying</option>
                            <option value="Grass">Grass</option>
                            <option value="Ghost">Ghost</option>
                            <option value="Ground">Ground</option>
                            <option value="Electric">Electric</option>
                            <option value="Normal">Normal</option>
                            <option value="Poison">Poison</option>
                            <option value="Psychic">Psychic</option>
                            <option value="Rock">Rock</option>
                            <option value="Water">Water</option>
                        </select>
                        <input type="button" class="randomPokemon col" onclick="randomPokemon()" value="Random" id="random-btn" />
                    </div>

                    <!--Pokemon List-->
                    <?php
                        //selects all pokemon
                        $pokemonResults = $conn->query("SELECT * from pokemon");
                    ?>
                    <div class="pokemonList">
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
                                    //displays pokemon results in table
                                    while ($allPokemon = $pokemonResults->fetch()) {
                                    $pidAll = $allPokemon['pid'];
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $allPokemon['pid']; //Number  ?>
                                    </td>
                                    <td>
                                        <a href='pokedex.php?pid=<?php echo $pidAll; //Name  ?>'>
                                            <?php echo $allPokemon['tname']; ?>
                                        </a>
                                    </td>
                                    <td class="table-toHide">
                                        <?php echo $allPokemon['type1']; //Type 1  ?>
                                    </td>
                                    <td class="table-toHide">
                                        <?php echo $allPokemon['type2']; //Type 2  ?>
                                    </td>
                                </tr>
                                <?php }; //loop ends ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Row 3-->
    <div class="row">

        <!--Footer-->
        <div class="col-sm" id="footer">
            <p>Fraser Provan 2018</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>