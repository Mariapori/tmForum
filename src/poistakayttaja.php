<?php
include_once("config.php");
session_start();

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}

$id = $_SESSION["KayttajaID"];
$poistaquery = mysqli_query($conn,"DELETE FROM kayttajat WHERE KayttajaID = '$id'");

if($poistaquery){
    session_destroy();
    session_unset();
}

header("Location: index.php");
?>