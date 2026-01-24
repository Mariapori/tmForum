<?php
session_start();
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}
if(!isset($_POST["LankaID"]) || !isset($_POST["Viesti"]) || !isset($_POST["csrf_token"])){
    header("Location: index.php");
    exit;
}

if(!verifyToken($_POST["csrf_token"])){
    echo "Virheellinen CSRF-token.";
    exit;
}

$lankaid = $_POST["LankaID"];
$msg = $_POST["Viesti"];
$kirjoittaja = $_SESSION["KayttajaID"];

// Insert message
$stmt = $conn->prepare("INSERT INTO langanviestit (Lanka, Viesti, Kirjoittaja) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $lankaid, $msg, $kirjoittaja);
$result = $stmt->execute();

// Fetch writer name
$stmt_writer = $conn->prepare("SELECT Kayttajanimi FROM kayttajat WHERE KayttajaID = ?");
$stmt_writer->bind_param("i", $kirjoittaja);
$stmt_writer->execute();
$res_writer = $stmt_writer->get_result();
$kirjoittajanimi = $res_writer->fetch_assoc()["Kayttajanimi"];

// Fetch thread name
$stmt_thread = $conn->prepare("SELECT Nimi FROM langat WHERE LankaID = ?");
$stmt_thread->bind_param("i", $lankaid);
$stmt_thread->execute();
$res_thread = $stmt_thread->get_result();
$lankanimi = $res_thread->fetch_assoc()["Nimi"];

// Email notification
$stmt_owner = $conn->prepare("SELECT k.Sposti, l.Luonut FROM langat l LEFT JOIN kayttajat k on k.KayttajaID = l.Luonut WHERE l.LankaID = ?");
$stmt_owner->bind_param("i", $lankaid);
$stmt_owner->execute();
$res_owner = $stmt_owner->get_result();

if($res_owner->num_rows > 0){
    while ($row = $res_owner->fetch_assoc()){
        if($row["Sposti"] != null && $row["Sposti"] != ""){
            if($kirjoittaja != $row["Luonut"]){
                $path = $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']) . '/lanka.php?id='.$lankaid;
                $headers = array();
                $headers[] = "From: tmForum <noreply@mariapori.fi>";
                $headers[] = "Content-Type: text/plain; charset=UTF-8";
                
                // Sanitize headers to prevent injection (though mail() is generally safer with modern PHP, good practice)
                $safe_lankanimi = str_replace(array("\r", "\n"), '', $lankanimi);
                
                mail($row["Sposti"],"Uusi viesti lankaan ". $safe_lankanimi, $kirjoittajanimi." kirjoitti: ".$msg."\r\nKatso foorumilla: ".$path, implode("\r\n", $headers));
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