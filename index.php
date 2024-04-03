<?php
session_start();

if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}


if(!isset($_POST['vista'])) {
	if(isset($_SESSION['vista'])) {
		$vista = $_SESSION['vista'];
	} else{$vista = "tickets";}
} else {
	$vista=$_POST['vista'];
}


//navbar url variable path
$home_url = "home.php";
$index_url = "index.php";
$ticket_url = "php/crud/ticket/crear_ticket.php";
$user_url = "php/crud/usuario/crear_usuario.php";
$category_url = "php/crud/categoria/crear_categoria.php";
$logout_url = "php/logout.php";
?>
	<?php require_once "php/navbar.php"; ?>
	<?php require_once "php/top_menu.php"; ?>

	<?php 

	if($vista == "tickets") {
		$_SESSION['render']=require_once "php/crud/ticket/vista_ticket.php"; $_SESSION['vista'] = $vista;}
	elseif($vista == "usuarios") {
		$_SESSION['render']=require_once "php/crud/usuario/vista_usuario.php"; $_SESSION['vista'] = $vista;}
	elseif($vista == "categorias") {
		$_SESSION['render']=require_once "php/crud/categoria/vista_categoria.php"; $_SESSION['vista'] = $vista;} 

	?>

	</body>
</html>