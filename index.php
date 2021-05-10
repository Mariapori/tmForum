<?php
session_start();

if(isset($_SESSION["KayttajaID"])){
    header("Location: menu.php");
}

?>
<!doctype html>
<html>
<head>
<title>tmForum - Kirjaudu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/tyyli.css">
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
<div id="kirjautuminen">
<table>
<tr>
<td><input id="kayttaja" placeholder="Käyttäjätunnus"></td>
</tr>
<tr>
<td><input id="salasana" placeholder="Salasana" type="password"></td>
</tr>
<tr>
<td><button onclick="Login()">Kirjaudu</button><button onclick="Register()">Luo tunnus</button></td>
</tr>
</table>
<p id="error"></p>
</div>
</body>
</html>

<script>

function Login(){
    var kayttaja = $("#kayttaja").val();
    var salasana = $("#salasana").val();

    $.ajax({
        url : "login.php",
        type : "POST",
        data : {
            "kayttaja" : kayttaja,
            "salasana" : salasana
        }
    }).done(function(data){
        if(data == 1){
            window.location = "menu.php";
        }else{
            $("#error").text(data);
        }
    });
}

function Register(){
    var kayttaja = $("#kayttaja").val();
    var salasana = $("#salasana").val();

    $.ajax({
        url : "register.php",
        type : "POST",
        data : {
            "kayttaja" : kayttaja,
            "salasana" : salasana
        }
    }).done(function(data){
        if(data == 1){
            window.location = "menu.php";
        }else{
            $("#error").text(data);
        }
    });
}

</script>