<?php
include_once("config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$kayttaja = $_POST["kayttaja"];
$salasana = $_POST["salasana"];

if(!isset($_POST["csrf_token"]) || !verifyToken($_POST["csrf_token"])){
    echo "Virheellinen CSRF-token.";
    exit;
}

$stmt = $conn->prepare("SELECT KayttajaID, Salasana FROM kayttajat WHERE Kayttajanimi = ?");
$stmt->bind_param("s", $kayttaja);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    if(password_verify($salasana, $row["Salasana"])){
        session_regenerate_id(true); // Prevent Session Fixation
        $_SESSION["KayttajaID"] = $row["KayttajaID"];
        echo 1;
    } else {
        echo "Käyttäjä tai salasana virheellinen!";
    }
}else{
    echo "Käyttäjä tai salasana virheellinen!";
}
?>