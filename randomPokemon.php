<?php
//Fraser Provan 22/06/2018
//script for generating random ID

//generates random number between 1 and 151
$randomid = rand(1, 151);

//opens pokedex using a randomly generated ID
header('Location: pokedex.php?pid=' . $randomid);

//Unsets variable after used
unset($randomid);
