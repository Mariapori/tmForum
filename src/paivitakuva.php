<?php
include_once("config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}
if(!isset($_POST["kuvanurl"]) || !isset($_POST["csrf_token"])){
    echo "Puuttuvat parametrit.";
    exit;
}

if(!verifyToken($_POST["csrf_token"])){
    echo "Virheellinen CSRF-token.";
    exit;
}

$kuvanurl = $_POST["kuvanurl"];
$id = $_SESSION["KayttajaID"];

$stmt = $conn->prepare("UPDATE kayttajat SET Kuva = ? WHERE KayttajaID = ?");
$stmt->bind_param("si", $kuvanurl, $id);

if($stmt->execute()){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}
?>