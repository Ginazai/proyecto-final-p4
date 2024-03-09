<?php
session_start();
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
	<div class="container">
	<div class="row">
	<div class="col-md-12">
			<h2>REGISTRO Y LOGIN BASICO</h2>
			<p class="lead">Sistema de Registro y Login Sencillo con PHP y MySQL</p>
			<p>Les presento <b>rl-php</b> un sistema de registro y login sencillo.</p>
			<p>Instrucciones:</p>
			<ol>
				<li>Registrate en la opcion de registro.</li>
				<li>Inicie sesion en la opcion de login.</li>
				<li>Para finalizar la sesion, click en la opcion salir .</li>
			</ol>
			<br>
			<ul type="none">
			<li><i class="glyphicon glyphicon-ok"></i> Facil de instalar y modificar</li>
			<li><i class="glyphicon glyphicon-ok"></i> Ideal para tu proximo proyecto web</li>
			</ul>
	</div>
	</div>
	</div>
	</body>
</html>