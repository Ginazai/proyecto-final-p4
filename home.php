<?php
session_start();
include "php/head_resources.php";
//navbar url variable path
$home_url = "home.php";
$index_url = "index.php";
$ticket_url = "php/crud/ticket/crear_ticket.php";
$user_url = "php/crud/usuario/crear_usuario.php";
$category_url = "php/crud/categoria/crear_categoria.php";
$logout_url = "php/logout.php";
?>

	<?php require_once "php/head_resources.php"; ?>
	<?php include "php/navbar.php"; ?>
	<?php include "html/carousel.php"; ?>
	</body>
</html>