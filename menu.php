<?php
session_start();

if(!isset($_SESSION["KayttajaID"])){
    header("Location: index.php");
}

?>
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
            <li><a href="profiili.php">Profiili</a></li>
            <li style="float: right;"><a href="ulos.php">Kirjaudu ulos</a></li>
        </ul>
    </div>
    <?php include("langat.php"); ?>
</body>
</html>
