<?php 
include '../../conexion.php';

$id=$_GET['id'];

$get_cantidad=$con->prepare("SELECT titulo,cantidad FROM data_buy WHERE id=:id");
$get_cantidad->execute([":id"=>$id]);
$fila= $get_cantidad->fetchAll()[0];
$titulo = $fila['titulo'];
$cantidad = $fila['cantidad'];

$re_insert=$con->prepare("SELECT cantidad FROM data_sales WHERE titulo=:title");
$re_insert->execute([":title"=>$titulo]);
$amount=$re_insert->fetchAll()[0];
$amount=$amount['cantidad'];

$new_amount=$amount+$cantidad;

$update_amount=$con->prepare("UPDATE data_sales SET cantidad=:c");
$update_amount->execute([":c"=>$new_amount]);

$remove_item=$con->prepare("DELETE FROM data_buy WHERE id=:id");
$remove_item->execute([":id"=>$id]);
echo("<script type='application/javascript'>window.location='../../../index.php';</script>");
?>
