<?php
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
    exit;
}
$id = $_SESSION["KayttajaID"];
$csrf_token = generateToken();

$admin = false;
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

$query = $conn->query("SELECT *, k.Kayttajanimi FROM langat LEFT JOIN kayttajat k on k.KayttajaID = Luonut");
echo "<h2 style='margin: 0 auto;max-width: 480px;background-color: #dfdfdfbd;padding: 10px;'>Langat:</h2>";
echo "<div id='langat-div'>";
if($query->num_rows > 0){
    echo "<ul id='langat'>";
    while($row = $query->fetch_assoc()){
        $date = date_create($row["PVM"]);
        echo "<li><div class='lankalistassa'> <a href='lanka.php?id=".htmlspecialchars($row["LankaID"])."'>".htmlspecialchars($row["Nimi"])."</a><p>Luonut: ".htmlspecialchars($row["Kayttajanimi"])." | ".date_format($date,'d.m.Y')."";
        if($_SESSION["KayttajaID"] == $row["Luonut"] || $admin == true){
            echo "<br><button onclick='PoistaLanka(".$row["LankaID"].")'>Poista lanka</button> </div></li>";
        }else{
            echo "</div></li>";
        }
    }
    echo "</ul>";
}else{
    echo "<ul id='langat'><li>Ei lankoja.</li></ul>";
}

echo "</div>";
echo "<span style='padding: 15px;margin: 0 auto;background-color: #dc7a7a;display: block;max-width: 470px;'>Langan nimi: <input id='LanganNimi'/> <button onclick='UusiLanka()'>Luo</button></span>
<input id='csrf_token_langat' value='".$csrf_token."' hidden/>
</div>";
?>

<script>
function UusiLanka(){
    var lanka = $("#LanganNimi").val();
    var token = $("#csrf_token_langat").val();
    $.ajax({
        url : "uusilanka.php",
        type : "POST",
        data : {
            "LanganNimi" : lanka,
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
function PoistaLanka(id){
    var token = $("#csrf_token_langat").val();
    $.ajax({
        url : "poistalanka.php",
        type : "POST",
        data : {
            "LankaID" : id,
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