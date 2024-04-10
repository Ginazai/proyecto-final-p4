<?php
session_start();
if(isset($_POST)){
	$id_compra = $_GET['id'];
	$amount_selected = $_POST['amount'];

	include '../../conexion.php';

	$get_amount = $con->prepare("SELECT * FROM data_sales WHERE id_compra = :id");
	$get_amount->execute([':id' => $id_compra]);
	$article = $get_amount->fetchAll()[0]; 
	//grabbing data
	$titulo = $article['titulo'];
	$descripcion = $article['descripcion'];
	$precio = $article['precio'];
	$amount = $article['cantidad'];

	if($amount > 0){
		/**
		 * Remove amount from inventory * */
		$new_amount = $amount - $amount_selected;
		$update_amount = $con->prepare("UPDATE data_sales SET cantidad = :amount WHERE id_compra = :id");
		$update_amount->execute([":amount" => $new_amount, ":id" => $id_compra]);
		/**
		 * Insert into cart */
		date_default_timezone_set("America/Panama");
		$username = $_SESSION['username'];
		$date = date("Y-m-d");  
		$order_id = $date . "-" . $username;
		$cart_insert = $con->prepare("INSERT INTO data_buy (id_orden, titulo, descripcion, precio, username, fechacompra, cantidad) VALUES (:order,:title,:description,:price,:username,NOW(),:n_amount)");
		$cart_insert->execute([
			':order' => $order_id,
			':title' => $titulo,
			':description' => $descripcion,
			':price' => $precio,
			':username' => $username,
			':n_amount' => $amount_selected
		]);
	echo("<script type='application/javascript'>window.location='../../../index.php';</script>");
	} else {
		$resultado['error'] = true;
		$resultado['mensaje'] = "Item out of stock";
	echo("<script type='application/javascript'>alert('Item out of stock');</script>");	
	echo("<script type='application/javascript'>window.location='../../../index.php';</script>");
	}
}
?>