<?php
session_start();

$config = include '../../conexion.php';
$last_element=null;
try {
  $sentencia = $con->prepare("INSERT INTO data_sales (titulo, descripcion, precio, username, fechacompra, cantidad, image)
    VALUES (:titulo, :descripcion, :precio, :username, NOW(), :cantidad, :image)");
    
    $image=$_FILES['upload-image']['tmp_name'];
    $image_data=file_get_contents($image);
    $base64_image=base64_encode($image_data);
    $sentencia->execute(array(
      ':titulo' => $_POST['titulo'],
      ':descripcion' => $_POST['desc'],
      ':precio' => $_POST['precio'],
      ':username' => $_SESSION['username'],
      ':cantidad' => $_POST['cantidad'],
      ':image' => $base64_image
    ));

  $resultado = ['error' => false, 'mensaje' => 'El articulo ' . $_POST['titulo'] . ' ha sido agregado con éxito'];
  $_SESSION['vista']="compras";
  header('Location: ../../../index.php');
} 
catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
  $_SESSION['vista']="compras";
  echo $resultado['mensaje']; 
  //header('Location: ../../../index.php');
}  
?>