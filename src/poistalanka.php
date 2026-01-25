<?php
include_once("config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_POST["LankaID"]) || !isset($_POST["csrf_token"])){
    header("Location: index.php");
    exit;
}

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}

if(!verifyToken($_POST["csrf_token"])){
    echo "Virheellinen CSRF-token.";
    exit;
}

$admin = false;

$id = $_SESSION["KayttajaID"];
$lanka = $_POST["LankaID"];

$stmt_admin = $conn->prepare("SELECT Rooli FROM kayttajat WHERE KayttajaID = ?");
$stmt_admin->bind_param("i", $id);
$stmt_admin->execute();
$res_admin = $stmt_admin->get_result();

if($res_admin->num_rows > 0){
    $row = $res_admin->fetch_assoc();
    if($row["Rooli"] == "Admin"){
        $admin = true;
    }
}

$stmt_del = false;

if($admin == true){
    $stmt_del = $conn->prepare("DELETE FROM langat WHERE LankaID = ?");
    $stmt_del->bind_param("i", $lanka);
}else{
    $stmt_del = $conn->prepare("DELETE FROM langat WHERE Luonut = ? AND LankaID = ?");
    $stmt_del->bind_param("ii", $id, $lanka);
}


if($stmt_del->execute() && $stmt_del->affected_rows > 0){
    echo 1;
}else{
    echo "Et voi poistaa!";
}
?>