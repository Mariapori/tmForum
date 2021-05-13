<?php
include_once("config.php");
session_start();

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}
$id = $_SESSION["KayttajaID"];
$profiilikuva = "";
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
        $profiilikuva = $row["Kuva"];
        echo "<img src='".$row["Kuva"]."'/>
        <h2>".$row["Kayttajanimi"]."</h2>
        ";
    }
}

?>
<div id="profiiliToiminnot">
    <p>Profiilikuva:</p>
    <input id="kuvanurl" value="<?php echo $profiilikuva; ?>"> <button onclick="VaihdaKuva()">Vaihda</button><br>
    <a style="border: 1px solid black; border-radius: 45px; padding: 10px;margin: 10px; display: inline-block; max-width: 100px;"href="poistakayttaja.php">Poista käyttäjä</a>
</div>
    </div>
</body>
</html>

<script>
function VaihdaKuva(){
    var kuvaurl = $("#kuvanurl").val();
    var id = <?php echo $id; ?>;

    $.ajax({
        url: "paivitakuva.php",
        type: "POST",
        data: {
            "kuvanurl" : kuvaurl,
            "id" : id
        }
    }).done(function(data){
        if(data == 1){
            window.location.reload();
        }
    });
}
</script>