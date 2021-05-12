<?php
include_once("config.php");
session_start();

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}
$id = $_SESSION["KayttajaID"];

$profiiliquery = mysqli_query($conn, "SELECT * FROM kayttajat WHERE KayttajaID = '$id'");

?>
<!doctype html>
<html>
<head>
<title>tmForum - Profiili</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/tyyli.css">
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
    <h1 id="menuheader">tmForum - Foorumisovellus</h1>
    <div id="valikko">
        <ul>
            <li><a href="menu.php">Etusivu</a></li>
            <li><a href="profiili.php">Profiili</a></li>
            <li style="float: right;"><a href="ulos.php">Kirjaudu ulos</a></li>
        </ul>
    </div>
    <div id="profiili">
<?php

if(mysqli_num_rows($profiiliquery) > 0){
    while($row = mysqli_fetch_assoc($profiiliquery)){
        echo "<img src='".$row["Kuva"]."'/>
        <h2>".$row["Kayttajanimi"]."</h2>
        ";
    }
}

?>
    </div>
</body>
</html>