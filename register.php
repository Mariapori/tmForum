<?php
include_once("config.php");
session_start();

$kayttaja = mysqli_escape_string($conn, $_POST["kayttaja"]);
$salasana = mysqli_escape_string($conn, $_POST["salasana"]);

$kryptatty = crypt($salasana, "ABCD1234");

$rooli = "Normaali";
$olemassa = false;

$result = mysqli_query($conn, "SELECT * From kayttajat");
if(mysqli_num_rows($result) == 0){
    $rooli = "Admin";
}else{
    while($row = mysqli_fetch_assoc($result)){
        if($kayttaja == $row["Kayttajanimi"]){
            $olemassa = true;
        }
    }
}

if(!$olemassa){
    $tulos = mysqli_query($conn, "INSERT INTO kayttajat (Kayttajanimi, Salasana, Rooli)
    VALUES ('$kayttaja', '$kryptatty', '$rooli');");
    if($tulos === true){
        echo 1;
    }else{
        echo "Jokin meni vituiksi!";
    }
}else{
    echo "Käyttäjänimi varattu!";
}

?>