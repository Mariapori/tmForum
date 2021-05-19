<?php
session_start();
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}
if(!isset($_POST["LankaID"])){
    header("Location: index.php");
}
if(!isset($_POST["Viesti"])){
    header("Location: index.php");
}

$lankaid = mysqli_escape_string($conn,$_POST["LankaID"]);
$msg = mysqli_escape_string($conn,$_POST["Viesti"]);
$kirjoittaja = $_SESSION["KayttajaID"];
$date = date('Y-m-d H:i:s');
$result = mysqli_query($conn,"INSERT INTO langanviestit (Lanka,Viesti,Kirjoittaja) VALUES ('$lankaid','$msg','$kirjoittaja');");

$onkoposti = mysqli_query($conn,"SELECT * FROM langat LEFT JOIN kayttajat k on k.KayttajaID = Luonut WHERE LankaID = '$lankaid'");

if(mysqli_num_rows($onkoposti) > 0){
    while ($row = mysqli_fetch_assoc($onkoposti)){
        if($row["Sposti"] != null && $row["Sposti"] != ""){
            if($kirjoittaja != $row["Luonut"]){
                mail($row["Sposti"],"Uusi viesti lankaan", $msg);
            }
        }
    }
}

if($result === true){
    echo 1;
}else{
    echo "Jokin meni pieleen.";
}

?>