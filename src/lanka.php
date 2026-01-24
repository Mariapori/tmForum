<?php
session_start();
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}

$ktid = $_SESSION["KayttajaID"];
$csrf_token = generateToken();

if(empty($_GET["id"])){
    header("Location: menu.php");
    exit;
}

$id = $_GET["id"];
$lankanimi = "";

$stmt = $conn->prepare("SELECT Nimi from langat WHERE LankaID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $lankanimi = $row["Nimi"];
}else{
    header("Location: menu.php");
    exit;
}

$admin = false;
$stmt_admin = $conn->prepare("SELECT Rooli FROM kayttajat WHERE KayttajaID = ?");
$stmt_admin->bind_param("i", $ktid);
$stmt_admin->execute();
$res_admin = $stmt_admin->get_result();

if($res_admin->num_rows > 0){
    $row = $res_admin->fetch_assoc();
    if($row["Rooli"] == "Admin"){
        $admin = true;
    }
}
?>
<!doctype html>
<html>
<head>
<title>tmForum - <?php echo htmlspecialchars($lankanimi); ?></title>
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
    <?php
    echo "<h2 style='margin: 0 auto;max-width: 480px;background-color: #dfdfdfbd;padding: 10px;'>Langan ".htmlspecialchars($lankanimi)." viestit</h2>";
    ?>
    <div id="lankaviestit">
    <ul>
        <?php
        $stmt_msgs = $conn->prepare("SELECT v.*, k.Kayttajanimi, k.Kuva FROM langanviestit v LEFT JOIN kayttajat k on k.KayttajaID = v.Kirjoittaja WHERE v.Lanka = ?");
        $stmt_msgs->bind_param("i", $id);
        $stmt_msgs->execute();
        $viestit = $stmt_msgs->get_result();
        
        if($viestit->num_rows > 0){
            while($row = $viestit->fetch_assoc()){
                $date = date_create($row["PVM"]);
                $kayttajanimi = htmlspecialchars($row["Kayttajanimi"]);
                $kuva = htmlspecialchars($row["Kuva"]);
                $viesti = nl2br(htmlspecialchars($row["Viesti"]));
                $pvm = date_format($date,'d.m.Y H:i:s');
                
                echo"<li><div class='lankaviesti'>
                <img src='".$kuva."' alt='Käyttäjän ".$kayttajanimi." profiilikuva' />
                <p class='viestinkirjoittaja'>Kirjoittaja: ".$kayttajanimi."</p>
                <p class='viestindatetime'>PVM: ".$pvm."</p>
                <p class='viesti'>Viesti: </br>".$viesti."</p>";
                
                if($row["Kirjoittaja"] == $_SESSION["KayttajaID"] || $admin == true){
                    echo "<button onclick='PoistaViesti(".$row["ViestiID"].")'>Poista viesti</button>";
                }
                echo "</div></li>";
            }
        }
        ?>
    </ul>
    <input id='lankaid' value='<?php echo htmlspecialchars($id); ?>' hidden/>
    <input id='csrf_token' value='<?php echo $csrf_token; ?>' hidden/>
    <span>Kirjoita: <textarea id="txtLanka"></textarea> <button onclick="Kirjoita()">Lähetä</button></span>
    </div>
</body>
</html>

<script>
function Kirjoita(){
    var viesti = $("#txtLanka").val();
    var id = $("#lankaid").val();
    var token = $("#csrf_token").val();
    $.ajax({
        url : "kirjoitalankaan.php",
        type : "POST",
        data : {
            "LankaID" : id,
            "Viesti" : viesti,
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

function PoistaViesti(id){
    var token = $("#csrf_token").val();
    $.ajax({
        url : "poistaviesti.php",
        type : "POST",
        data : {
            "ViestiID" : id,
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
</script>