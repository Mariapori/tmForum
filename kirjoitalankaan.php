<?php
session_start();
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}

$lankaid = mysqli_escape_string($conn,$_POST["LankaID"]);
$msg = mysqli_escape_string($conn,$_POST["Viesti"]);
$kirjoittaja = $_SESSION["KayttajaID"];
$date = date('Y-m-d H:i:s');
$result = mysqli_query($conn,"INSERT INTO langanviestit (Lanka,Viesti,Kirjoittaja) VALUES ('$lankaid','$msg','$kirjoittaja');");
if($result === true){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}

?>