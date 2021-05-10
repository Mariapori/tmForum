<?php
include_once("config.php");
session_start();

$kayttaja = mysqli_escape_string($conn, $_POST["kayttaja"]);
$salasana = mysqli_escape_string($conn, $_POST["salasana"]);

$kryptatty = crypt($salasana, "ABCD1234");

$tulos = mysqli_query($conn, "SELECT * FROM kayttajat WHERE Kayttajanimi = '$kayttaja' AND Salasana = '$kryptatty'");

if(mysqli_num_rows($tulos) > 0){
    echo 1;
    while($row = mysqli_fetch_assoc($tulos)){
        $_SESSION["KayttajaID"] = $row["KayttajaID"];
    }
}else{
    echo "Käyttäjä tai salasana virheellinen!";
}

?>