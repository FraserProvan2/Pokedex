function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}    

function randomPokemon(){
    var randomNum = Math.floor(Math.random() * 151) + 1;  
    document.location.replace('pokedex.php?pid=' + randomNum);
}
