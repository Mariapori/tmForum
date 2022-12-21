<?php
include_once("config.php");
session_start();

if(!isset($_POST["LankaID"])){
    header("Location: index.php");
    exit;
}

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}

$admin = false;

$id = $_SESSION["KayttajaID"];
$lanka = mysqli_escape_string($conn,$_POST["LankaID"]);

$adminquery = mysqli_query($conn,"SELECT * FROM kayttajat WHERE KayttajaID = '$id'");
if(mysqli_num_rows($adminquery) > 0){
    while($row = mysqli_fetch_assoc($adminquery)){
        if($row["Rooli"] == "Admin"){
            $admin = true;
        }
    }
}

$poistaquery = false;

if($admin == true){
    $poistaquery = mysqli_query($conn,"DELETE FROM langat WHERE LankaID = '$lanka'");
}else{
    $poistaquery = mysqli_query($conn,"DELETE FROM langat WHERE Luonut = '$id' AND LankaID = '$lanka'");
}


if($poistaquery == true){
    echo 1;
}else{
    echo "Et voi poistaa!";
}

?>