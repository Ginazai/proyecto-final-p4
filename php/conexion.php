<?php
$host="localhost";
$user="root";
$password="";
$db="myapp";

$dsn = "mysql:host=$host;dbname=$db";
$con = new PDO($dsn, $user, $password);

?>