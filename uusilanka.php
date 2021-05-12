<?php
session_start();
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}

$msg = mysqli_escape_string($conn,$_POST["LanganNimi"]);
$kirjoittaja = $_SESSION["KayttajaID"];
$date = date('Y-m-d H:i:s');
$result = mysqli_query($conn,"INSERT INTO langat (Nimi,Luonut) VALUES ('$msg','$kirjoittaja');");
if($result === true){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}

?>