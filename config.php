<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "marketplace";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>

