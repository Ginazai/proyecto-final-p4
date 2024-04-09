<?php
if(isset($_POST)){
	$id = $_GET['id'];
	$amount_selected = $_POST['amount'];

	include '../../conexion.php';

	$get_amount = $con->prepare("SELECT cantidad FROM data_sales WHERE id_compra = :id");
	$get_amount->execute([':id' => $id]);
	$amount = $get_amount->fetchAll()[0]['cantidad'];

	if($amount > 0){
		$new_amount = $amount - $amount_selected;
		$update_amount = $con->prepare("UPDATE data_sales SET cantidad = :amount WHERE id_compra = :id");
		$update_amount->execute([":amount" => $new_amount, ":id" => $id]);
	echo("<script type='application/javascript'>window.location='../../../index.php';</script>");
	} else {
		$resultado['error'] = true;
		$resultado['mensaje'] = "Item out of stock";
	echo("<script type='application/javascript'>alert('Item out of stock');</script>");	
	echo("<script type='application/javascript'>window.location='../../../index.php';</script>");
	}
}
?>