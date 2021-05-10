<?php
session_start();
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}
if($_GET["id"] == null || $_GET["id"] == ""){
    header("Location: menu.php");
}else{
    $id = mysqli_real_escape_string($conn,$_GET["id"]);
    $lankaquery = mysqli_query($conn, "SELECT Nimi from langat WHERE LankaID = '$id'");
    if(mysqli_num_rows($lankaquery) > 0){
        while($row = mysqli_fetch_assoc($lankaquery)){
            $lankanimi = $row["Nimi"];
        }
}else{
    header("Location: menu.php");
}
}

?>
<!doctype html>
<html>
<head>
<title>tmForum - Valikko</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/tyyli.css">
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
    <h1 id="menuheader">tmForum - Foorumisovellus</h1>
    <div id="valikko">
        <ul>
            <li><a href="menu.php">Etusivu</a></li>
            <li><a href="#">Profiili</a></li>
            <li style="float: right;"><a href="ulos.php">Kirjaudu ulos</a></li>
        </ul>
    </div>
    <?php
    echo "<h2 style='margin: 0 auto;max-width: 480px;background-color: #dfdfdfbd;padding: 10px;'>Langan ".$lankanimi." viestit</h2>";
    ?>
    <div id="lankaviestit">
    <ul>
        <?php
        $viestit = mysqli_query($conn,"SELECT *, k.Kayttajanimi FROM langanviestit LEFT JOIN kayttajat k on k.KayttajaID = Kirjoittaja WHERE Lanka = '$id'");
        if(mysqli_num_rows($viestit) > 0){
            while($row = mysqli_fetch_assoc($viestit)){
                $date = date_create($row["PVM"]);
                echo "<li><div class='lankaviesti'>
                <p class='viestinkirjoittaja'>Kirjoittaja: ".$row["Kayttajanimi"]."</p>
                <p class='viestindatetime'>PVM: ".date_format($date,'d.m.Y H:i:s')."</p>
                <p class='viesti'>Viesti: </br>".$row["Viesti"]."</p>
                </div></li>";
            }
        }
        ?>
    </ul>
    <?php echo "<input id='lankaid' value='".$id."' hidden/>" ?>
    <span>Kirjoita: <textarea id="txtLanka"></textarea> <button onclick="Kirjoita()">Lähetä</button></span>
    </div>
</body>
</html>

<script>
function Kirjoita(){
    var viesti = $("#txtLanka").val();
    var id = $("#lankaid").val();
    $.ajax({
        url : "kirjoitalankaan.php",
        type : "POST",
        data : {
            "LankaID" : id,
            "Viesti" : viesti
        }
    }).done(function(data){
        if(data == 1){
            window.location.reload();
        }else{
            alert(data);
        }
        
    });
}
</script>