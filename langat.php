<?php
include_once("config.php");

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}

$query = mysqli_query($conn,"SELECT *, k.Kayttajanimi FROM langat LEFT JOIN kayttajat k on k.KayttajaID = Luonut");
echo "<h2 style='margin: 0 auto;max-width: 480px;background-color: #dfdfdfbd;padding: 10px;'>Langat:</h2>";
echo "<div id='langat-div'>";
if(mysqli_num_rows($query) > 0){
    echo "<ul id='langat'>";
    while($row = mysqli_fetch_assoc($query)){
        $date = date_create($row["PVM"]);
        echo "<li><div class='lankalistassa'> <a href='lanka.php?id=".$row["LankaID"]."'>".$row["Nimi"]."</a><p>Luonut: ".$row["Kayttajanimi"]." | ".date_format($date,'d.m.Y')."</div></li>";
    }
    echo "</ul>";
}else{
    echo "<ul id='langat'><li>Ei lankoja.</li></ul>";
}

echo "</div>";
echo "<span style='padding: 15px;margin: 0 auto;background-color: #dc7a7a;display: block;max-width: 470px;'>Langan nimi: <input id='LanganNimi'/> <button onclick='UusiLanka()'>Luo</button></span>
</div>";


?>

<script>
function UusiLanka(){
    var lanka = $("#LanganNimi").val();
    $.ajax({
        url : "uusilanka.php",
        type : "POST",
        data : {
            "LanganNimi" : lanka
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