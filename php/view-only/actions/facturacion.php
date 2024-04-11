<?php
session_start();
include "../../conexion.php";

$username = $_SESSION['username'];

$get_buy = $con->prepare("SELECT * FROM data_buy WHERE username=:uname");
$get_buy->execute([":uname"=>$username]);
$data = $get_buy->fetchAll();

foreach($data as $item){
	$buy_id = $item['id_orden'];;
	$titulo = $item['titulo'];
	$descripcion = $item['descripcion'];
	$precio = $item['precio'];
	$fechacompra = $item['fechacompra'];
	$cantidad = $item['cantidad'];

	$insert = $con->prepare("INSERT INTO data_fact (id_fact,titulo,descripcion,precio,username,fechacompra,cantidad) VALUES (:id,:title,:description,:price,:uname,NOW(),:amount)");
	$insert->execute([
		':id' => $buy_id,
		':title' => $titulo,
		':description' => $descripcion,
		':price' => $precio,
		':uname' => $username,
		':amount' => $cantidad
	]);

	$remove_order = $con->prepare("DELETE FROM data_buy WHERE username=:uname");
	$remove_order->execute([":uname"=>$username]);
}
$_SESSION['vista']="factura";
echo("<script type='application/javascript'>window.location='../../../index.php'</script>");
?>