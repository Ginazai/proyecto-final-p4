<?php
session_start();

if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

//navbar url variable path
$home_url = "index.php";
$ticket_url = "php/crud/ticket/crear_ticket.php";
$user_url = "php/crud/usuario/crear_usuario.php";
$category_url = "php/crud/categoria/crear_categoria.php";
$logout_url = "php/logout.php";
?>
	<?php require_once "php/head_resources.php"; ?>
	<?php require_once "php/navbar.php"; ?>
	<?php require_once "php/top_menu.php"; ?>

	<?php 

	if(isset($_POST['vista'])) {
		$vista = $_POST['vista'];
		if($vista == "tickets") {
			$_SESSION['render']=require_once "php/crud/ticket/vista_ticket.php"; 
		}
		elseif($vista == "usuarios") {
			$_SESSION['render']=require_once "php/crud/usuario/vista_usuario.php";
		}
		elseif($vista == "categorias") {
			$_SESSION['render']=require_once "php/crud/categoria/vista_categoria.php";
		}
	} else {
		$_SESSION['render']=require_once "php/crud/ticket/vista_ticket.php"; 
	}
	?>

	</body>
</html>