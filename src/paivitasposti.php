<?php
include_once("config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}
if(!isset($_POST["sposti"]) || !isset($_POST["csrf_token"])){
    echo "Puuttuvat parametrit.";
    exit;
}

if(!verifyToken($_POST["csrf_token"])){
    echo "Virheellinen CSRF-token.";
    exit;
}

$sposti = $_POST["sposti"];
$id = $_SESSION["KayttajaID"];

$stmt = $conn->prepare("UPDATE kayttajat SET Sposti = ? WHERE KayttajaID = ?");
$stmt->bind_param("si", $sposti, $id);

if($stmt->execute()){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}
?>