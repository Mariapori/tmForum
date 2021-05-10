<?php
include_once("config.php");
session_start();

$kayttaja = mysqli_escape_string($conn, $_POST["kayttaja"]);
$salasana = mysqli_escape_string($conn, $_POST["salasana"]);

$kryptatty = crypt($salasana, "ABCD1234");

$rooli = "Normaali";

$result = mysqli_query($conn, "SELECT * From kayttajat");
if(mysqli_num_rows($result) == 0){
    $rooli = "Admin";
}

$tulos = mysqli_query($conn, "INSERT INTO kayttajat (Kayttajanimi, Salasana, Kuva, Rooli)
VALUES ('$kayttaja', '$kryptatty', 'kuva', '$rooli');");

if($tulos === true){
    echo 1;
}else{
    echo "Jokin meni vituiksi!";
}

?>