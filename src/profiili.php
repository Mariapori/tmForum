<?php
include_once("config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}
$id = $_SESSION["KayttajaID"];
$csrf_token = generateToken();

$profiilikuva = "";
$sposti = "";
$kayttajanimi = "";

$stmt = $conn->prepare("SELECT * FROM kayttajat WHERE KayttajaID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $profiilikuva = $row["Kuva"];
        $sposti = $row["Sposti"];
        $kayttajanimi = $row["Kayttajanimi"];
    }
}
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
        echo "<img src='".htmlspecialchars($profiilikuva ?? "")."'/>
        <h2>".htmlspecialchars($kayttajanimi ?? "")."</h2>
        ";
    ?>
    <div id="profiiliToiminnot">
        <p>Profiilikuva:</p>
        <input id="kuvanurl" value="<?php echo htmlspecialchars($profiilikuva ?? ""); ?>"> <button onclick="VaihdaKuva()">Vaihda</button><br>
        <p>Sähköposti:</p>
        <input id="sposti" value="<?php echo htmlspecialchars($sposti ?? ""); ?>"> <button onclick="VaihdaSposti()">Vaihda</button><br>
        <button style="border: 1px solid black; border-radius: 45px; padding: 10px;margin: 10px; display: inline-block; max-width: 150px; background: red; color: white; cursor: pointer;" onclick="PoistaKayttaja()">Poista käyttäjä</button>
        <input id="csrf_token" value="<?php echo $csrf_token; ?>" hidden>
    </div>
    </div>
</body>
</html>

<script>
function VaihdaKuva(){
    var kuvaurl = $("#kuvanurl").val();
    var id = <?php echo $id; ?>;
    var token = $("#csrf_token").val();

    $.ajax({
        url: "paivitakuva.php",
        type: "POST",
        data: {
            "kuvanurl" : kuvaurl,
            "id" : id,
            "csrf_token" : token
        }
    }).done(function(data){
        if(data == 1){
            window.location.reload();
        }else{
            alert(data);
        }
    });
}

function VaihdaSposti(){
    var sposti = $("#sposti").val();
    var id = <?php echo $id; ?>;
    var token = $("#csrf_token").val();

    $.ajax({
        url: "paivitasposti.php",
        type: "POST",
        data: {
            "sposti" : sposti,
            "id" : id,
            "csrf_token" : token
        }
    }).done(function(data){
        if(data == 1){
            window.location.reload();
        }else{
            alert(data);
        }
    });
}

function PoistaKayttaja(){
    if(confirm("Haluatko varmasti poistaa käyttäjätilisi? Tätä toimintoa ei voi peruuttaa.")){
        var token = $("#csrf_token").val();
        $.ajax({
            url: "poistakayttaja.php",
            type: "POST",
            data: {
                "csrf_token" : token
            }
        }).done(function(data){
            if(data == 1){
                window.location = "index.php";
            }else{
                alert(data);
                // Try redirecting anyway if it succeeded but returned weirdly, or just alert error.
                // Actually poistakayttaja.php redirects in the original code. 
                // Since we are using AJAX, we should handle redirect here or let the PHP return 1.
                // The original code redirected. I will modify poistakayttaja.php to return 1 or error.
            }
        });
    }
}
</script>