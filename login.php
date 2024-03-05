<?php session_start();
include "php/head_resources.php";
//navbar url variable path
$index_url = "index.php";
$home_url = "home.php";
$ticket_url = "php/crud/ticket/crear_ticket.php";
$user_url = "php/crud/usuario/crear_usuario.php";
$category_url = "php/crud/categoria/crear_categoria.php";
$logout_url = "logout.php"; 
include "php/navbar.php"; 
?>
<div class="container">
<div class="row">
<div class="col-md-6">
		<h2>Login</h2>

		<form role="form" name="login" action="php/login.php" method="post">
		  <div class="form-group">
		    <label for="username">Nombre de usuario o email</label>
		    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario">
		  </div>
		  <div class="form-group">
		    <label for="password">Contrase&ntilde;a</label>
		    <input type="password" class="form-control" id="password" name="password" placeholder="Contrase&ntilde;a">
		  </div>

		  <button type="submit" class="btn btn-primary">Acceder</button>
		</form>
</div>
</div>
</div>
		<script src="js/valida_login.js"></script>
	</body>
</html>