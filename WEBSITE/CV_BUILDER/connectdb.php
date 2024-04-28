<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_builder";

$conn =new mysqli($servername,$username,$password,$dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

?>