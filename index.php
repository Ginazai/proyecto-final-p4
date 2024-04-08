<?php
session_start();

if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='home.php';</script>";
}

// echo(var_dump(in_array(6, )));
if(!isset($_POST['vista'])) {
	if(isset($_SESSION['vista'])){
		$vista = $_SESSION['vista'];
	} else {
		if(in_array(1, $_SESSION['Roles'])){
			$vista = "tickets";
		} elseif(in_array(2, $_SESSION['Roles'])) {
			$vista = "compras";
		} elseif(in_array(6, $_SESSION['Roles'])){
			$vista = "compras";
		}
	}
} else {
	$vista=$_POST['vista'];}


//navbar url variable path
$home_url = "home.php";
$index_url = "index.php";
$customer_url = "php/view-only/vista_cliente.php";
$ticket_url = "php/crud/ticket/crear_ticket.php";
$user_url = "php/crud/usuario/crear_usuario.php";
$category_url = "php/crud/categoria/crear_categoria.php";
$compras_url = "php/crud/compra/vista_compra.php";
$logout_url = "php/logout.php";
?>
	<?php require_once "html/navbar.php"; ?>
	<?php require_once "html/top_menu.php"; ?>

	<?php 
	if(in_array(2, $_SESSION['Roles'])&&!in_array(1, $_SESSION['Roles'])&&!in_array(6, $_SESSION['Roles'])){
		if($vista == "compras"){
				$_SESSION['render']=require_once "php/view-only/vista_cliente.php"; $_SESSION['vista'] = $vista;}
		else {
				$_SESSION['render']=require_once "php/view-only/vista_cliente.php"; $_SESSION['vista'] = $vista;}
	}
	if(in_array(1, $_SESSION['Roles'])){
		if($vista == "tickets") {
		$_SESSION['render']=require_once "php/crud/ticket/vista_ticket.php"; $_SESSION['vista'] = $vista;}
		elseif($vista == "usuarios") {
			$_SESSION['render']=require_once "php/crud/usuario/vista_usuario.php"; $_SESSION['vista'] = $vista;}
		elseif($vista == "categorias") {
			$_SESSION['render']=require_once "php/crud/categoria/vista_categoria.php"; $_SESSION['vista'] = $vista;} 
	}

	if(in_array(6, $_SESSION['Roles'])){
		if($vista == "compras"){
			$_SESSION['render']=require_once "php/crud/compra/vista_compra.php"; $_SESSION['vista'] = $vista;}
	}
	

	?>

	</body>
</html>