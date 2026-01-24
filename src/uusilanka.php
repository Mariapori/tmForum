<?php
session_start();
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}
if(!isset($_POST["LanganNimi"]) || !isset($_POST["csrf_token"])){
    header("Location: index.php");
    exit;
}

if(!verifyToken($_POST["csrf_token"])){
    echo "Virheellinen CSRF-token.";
    exit;
}

$msg = $_POST["LanganNimi"];
$kirjoittaja = $_SESSION["KayttajaID"];

$stmt = $conn->prepare("INSERT INTO langat (Nimi, Luonut) VALUES (?, ?)");
$stmt->bind_param("si", $msg, $kirjoittaja);

if($stmt->execute()){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}
?>