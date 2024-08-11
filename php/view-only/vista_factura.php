<?php
$error = false;
$config = include 'php/conexion.php';

try {
  date_default_timezone_set("America/Panama");
  $username=$_SESSION['username'];
  $user_name=$_SESSION['user_name'];
  $date=date("d-m-y");
  $date_2 = date("Y-m-d");  

  $last_receipt=$_SESSION['last_receipt'];
  $sale_id = (string)$last_receipt;
  while(strlen($sale_id) < 10){
    $sale_id = "0" . $sale_id; 
  }

  $sentencia = $con->prepare("SELECT receipt_list.cantidad, receipt_list.precio,
                              data_sales.titulo, data_sales.precio FROM receipt_list 
                              RIGHT JOIN data_sales ON receipt_list.id_prod = data_sales.id_compra
                              where receipt_list.id_receipt=:ilist");
  $sentencia->execute([":ilist"=>$last_receipt]);

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
    <div class="col-md-12">
      <img class="float-end my-4" width='50px' height='50px' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACTElEQVR4nO2ZsU4bQRCGPzi7pgw0pAqmgrPShTavQBmnSwPvEb8ENJDCRWgcp03JA9AEKFL7EBRgQxNstNJEWll7e2bv1rer+JdWPu3Je/Pvzsx/MwdL/D9oAz+BB+AeGAApkWEbGAPTmaHmWkSEMzG8B7yR0ZO570SETIxe1+Y2ZG5IJGhobqWMj45IA+gAV1pM9ORU1mNwrYaBwDUwMgT7KMRgbxgIqOvPck+l2h+SetXoA7sEhFVgH/itEfgDfBECwQtZUnACi7bHWciuF0wAMXjkIqw2IVskgX/ouwqrTcjGNcRA5iqsmUXI7lg87lyF9cwiZBPgBNj0bz+b8qyJq7C2LMH1JNfq9yuw5oHAmqytP2vsKqwmIduRXTrVdkm54QHQrIBAU9bKtNP/Brz1KazvgV/a7lyKQLriI3ChrXcO7FVhaBkDPlSwISvUAJNLnIobpqLCDzIG4hKzLnoDHFbkopUEaVcL0kdL0njUArnrKWlUljb/WhT5WU5EBXLwuLUoch3C6ows5lJ33jeEYEtdE1oiXrPBfh9iqVuEd8CRlmaPZC5aTGVEj2ldRNoVN5/LEmm72ONcI3sikrra41wjeyLS91GzD2sgkvmo2V2bD65EkjLNcJsiu7aDXkskAT5JfTKtumYflegwzkvERKBUMzyvRjY9aB5CRUTy1u34boa/tomdRySYZnhScEJbwLF271jmik6gNuT5dt7b71VoBObNNhsyegYC6j/BItHyf14zPGgCOpalbmiwCWt0pW4a+lfdJfCIF9JzmAbJezUhAAAAAElFTkSuQmCC'>
      <h2 class="mt-3"><?= $titulo ?></h2>
      <h5 class="my-1"><?= "Factura#: " . $sale_id ?></h5>
      <h5 class="my-1"><?= "Nombre del cliente: " . $user_name ?></h5>
      <h5 class="my-1"><?= "Fecha: " . $date ?></h5>
      <button class="btn btn-dark float-end" type="submit"><a class="text-white" href="php/view-only/actions/create_pdf.php?id_factura=<?=$_SESSION['last_receipt']?>">Descargar factura</a></button>
      <table class="table table-hover">
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