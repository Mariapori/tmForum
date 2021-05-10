
<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user "root" with no password) */
define("DB_SERVER", "localhost");
define("DB_USERNAME", "asd");
define("DB_PASSWORD", "");
define("DB_NAME", "tmForum");
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === false){
    die("VIRHE: " . mysqli_connect_error());
}
?>