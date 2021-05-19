<?php
include_once("config.php");
session_start();

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}
if(!isset($_POST["sposti"])){
    header("Location: index.php");
}

$sposti = mysqli_escape_string($conn,$_POST["sposti"]);

$id = $_SESSION["KayttajaID"];
$updatequery = mysqli_query($conn,"UPDATE kayttajat SET Sposti = '$sposti' WHERE KayttajaID = '$id'");

if($updatequery == true){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}

?>