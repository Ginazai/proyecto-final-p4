<?php
session_start();
session_destroy();
/**
 * Modify session table to set it as "inactive"*/
include 'conexion.php';

$inactive_query = $con->prepare("INSERT INTO session (username, is_active, last_activity) VALUES (:uname, :active, :lactivity)");
$inactive_query->execute([':active' => 0, ':lactivity' => date("Y-m-d H-i-s"), ':uname' => $_SESSION['username']]);

print "<script>window.location='../home.php';</script>";
?>