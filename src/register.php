<?php
include_once("config.php");
session_start();

$kayttaja = $_POST["kayttaja"];
$salasana = $_POST["salasana"];

$hashed_password = password_hash($salasana, PASSWORD_DEFAULT);

$rooli = "Normaali";

// Check if admin exist
$result = $conn->query("SELECT Count(*) as count FROM kayttajat");
$row = $result->fetch_assoc();
if($row['count'] == 0){
    $rooli = "Admin";
}

// Check if user exists
$stmt = $conn->prepare("SELECT KayttajaID FROM kayttajat WHERE Kayttajanimi = ?");
$stmt->bind_param("s", $kayttaja);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows == 0){
    $stmt = $conn->prepare("INSERT INTO kayttajat (Kayttajanimi, Salasana, Rooli) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $kayttaja, $hashed_password, $rooli);
    
    if($stmt->execute()){
        echo 1;
    }else{
        echo "Jokin meni vikaan!";
    }
}else{
    echo "Käyttäjänimi varattu!";
}
?>