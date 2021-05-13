<?php
include_once("config.php");
session_start();

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}
if(!isset($_POST["kuvanurl"])){
    header("Location: index.php");
}

$kuvanurl = mysqli_escape_string($conn,$_POST["kuvanurl"]);

$id = $_SESSION["KayttajaID"];
$updatequery = mysqli_query($conn,"UPDATE kayttajat SET Kuva = '$kuvanurl' WHERE KayttajaID = '$id'");

if($updatequery == true){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}

?>