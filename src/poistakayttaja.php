<?php
include_once("config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}

if(!isset($_POST["csrf_token"])){
    echo "Puuttuva CSRF-token.";
    exit;
}

if(!verifyToken($_POST["csrf_token"])){
    echo "Virheellinen CSRF-token.";
    exit;
}

$id = $_SESSION["KayttajaID"];

$stmt = $conn->prepare("DELETE FROM kayttajat WHERE KayttajaID = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    session_destroy();
    session_unset();
    echo 1;
} else {
    echo "Virhe poistettaessa käyttäjää.";
}
?>