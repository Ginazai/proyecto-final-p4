<?php
session_start();
session_destroy();
/**
 * Modify session table to set it as "inactive"*/
$config = include 'config.php';
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

$inactive_query = $conexion->prepare("UPDATE session SET is_active = :active, last_activity = :lactivity WHERE user_id = :uid");
$inactive_query->execute([':active' => 0, ':lactivity' => date("Y-m-d H-i-s"), ':uid' => $_SESSION['user_id']]);

print "<script>window.location='../login.php';</script>";
?>