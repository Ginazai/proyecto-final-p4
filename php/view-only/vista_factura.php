<?php
$error = false;
$config = include 'php/conexion.php';

try {
  $username=$_SESSION['username'];
  $user_name=$_SESSION['user_name'];
  $date=date("d-m-y");

  $sentencia = $con->prepare("SELECT * FROM data_fact where username=:uname");
  $sentencia->execute([":uname"=>$username]);

  $detalles = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = 'Detalles de la orden:';
?>

<?php
if ($error) {

  echo("
    <div class='container mt-2'>
      <div class='row'>
        <div class='col-md-12'>
          <div class='alert alert-danger' role='alert'>
            $error 
          </div>
        </div>
      </div>
    </div>");

}
?>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <h5 class="my-1"><?= "Factura #: " ?></h5>
      <h5 class="my-1"><?= "Nombre del cliente: " . $user_name ?></h5>
      <h5 class="my-1"><?= "Fecha: " . $date ?></h5>
      <table class="table table-hover" style="background: url('<?= $logo ?>') center cover no-repeat;">
        <thead>
          <tr>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($detalles && $sentencia->rowCount() > 0) {
            $total=0.00;
            foreach ($detalles as $producto) {
              ?>
              <tr>
                <td><?php echo $producto["titulo"]; ?></td>
                <td><?php echo $producto["cantidad"]; ?></td>
                <td><?php echo $producto["precio"]; ?></td>
                <td><?php echo $producto["precio"] * $producto["cantidad"]; ?></td>
              </tr>
              <?php
              $total+=$producto["precio"]*$producto['cantidad'];
            }
            $itbms=$total*0.07;
          }
          ?>
          <tr>
            <td><b>Total:</b></td>
            <td></td>
            <td></td>
            <td><b><?= round($total, 2); ?></b></td>
          </tr>
          <tr>
            <td><b>ITBMS:</b></td>
            <td></td>
            <td></td>
            <td><b><?= round($itbms, 2); ?></b></td>
          </tr>
          <tr>
            <td><b>Sub-total:</b></td>
            <td></td>
            <td></td>
            <td><b><?= round($total+$itbms, 2); ?></b></td>
          </tr>
        <tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="form-group my-3">
      <form id="go-back" name="go-back" action="php/view-only/actions/goto_sales.php" type="post"></form>
      <button form="go-back" class="btn btn-secondary" type="submit">Regresar al inicio</button>
    </div>
  </div>
</div>