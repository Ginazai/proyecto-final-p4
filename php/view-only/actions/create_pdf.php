<?php
session_start();
require __DIR__ . '../../../../vendor/autoload.php';
 // Reference the Dompdf namespace 
use Dompdf\Dompdf; 
try {
    $id=$_GET['id_factura'];
    $username=$_SESSION['username'];
    $config = include '../../conexion.php';
    $sale_id=$id;
    while(strlen($sale_id) < 10){
        $sale_id = "0" . $sale_id; 
      }
    $get_data=$con->prepare("SELECT receipt_list.id_prod, receipt.fechacompra,
                              receipt_list.cantidad, data_sales.titulo,
                              receipt_list.precio, receipt_list.id_receipt
                              FROM receipt_list INNER JOIN data_sales
                              ON receipt_list.id_prod = data_sales.id_compra
                              INNER JOIN receipt ON receipt.id = receipt_list.id_receipt
                              WHERE receipt_list.id_receipt = :idr and receipt_list.username=:uname");
     $get_data->execute([
        ":idr" => $id,
        ":uname"=>$username
    ]);

    $detalles=$get_data->fetchAll();

    $titulo = 'Detalles de la orden:';
    $user_name=$_SESSION['user_name'];

    $date=$detalles[0]['fechacompra'];

   $html ="<style>".file_get_contents("../../../html/assets/css/bootstrap.min.css")."</style>";

    $html .="
    <div class='container-fluid' width='100%' style='text-align:center;'>
    <img width='50px' height='50px' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACTElEQVR4nO2ZsU4bQRCGPzi7pgw0pAqmgrPShTavQBmnSwPvEb8ENJDCRWgcp03JA9AEKFL7EBRgQxNstNJEWll7e2bv1rer+JdWPu3Je/Pvzsx/MwdL/D9oAz+BB+AeGAApkWEbGAPTmaHmWkSEMzG8B7yR0ZO570SETIxe1+Y2ZG5IJGhobqWMj45IA+gAV1pM9ORU1mNwrYaBwDUwMgT7KMRgbxgIqOvPck+l2h+SetXoA7sEhFVgH/itEfgDfBECwQtZUnACi7bHWciuF0wAMXjkIqw2IVskgX/ouwqrTcjGNcRA5iqsmUXI7lg87lyF9cwiZBPgBNj0bz+b8qyJq7C2LMH1JNfq9yuw5oHAmqytP2vsKqwmIduRXTrVdkm54QHQrIBAU9bKtNP/Brz1KazvgV/a7lyKQLriI3ChrXcO7FVhaBkDPlSwISvUAJNLnIobpqLCDzIG4hKzLnoDHFbkopUEaVcL0kdL0njUArnrKWlUljb/WhT5WU5EBXLwuLUoch3C6ows5lJ33jeEYEtdE1oiXrPBfh9iqVuEd8CRlmaPZC5aTGVEj2ldRNoVN5/LEmm72ONcI3sikrra41wjeyLS91GzD2sgkvmo2V2bD65EkjLNcJsiu7aDXkskAT5JfTKtumYflegwzkvERKBUMzyvRjY9aB5CRUTy1u34boa/tomdRySYZnhScEJbwLF271jmik6gNuT5dt7b71VoBObNNhsyegYC6j/BItHyf14zPGgCOpalbmiwCWt0pW4a+lfdJfCIF9JzmAbJezUhAAAAAElFTkSuQmCC'>

  <div class='row'>
    <div class='col-md-12'>
      <h2 class='mt-3'>$titulo</h2>
      <h5 class='my-1'>Factura#: $sale_id</h5>
      <h5 class='my-1'>Nombre del cliente: $user_name</h5>
      <h5 class='my-1'>Fecha: $date</h5>
      <table class='table my-5'>
        <thead>
          <tr>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
        ";
     
          if ($detalles && $get_data->rowCount() > 0) {
            $total=0.00;
            foreach ($detalles as $producto) {
                $titulo=$producto['titulo'];
                $cantidad=$producto['cantidad'];
                $precio=$producto['precio'];
                $temp_total=$cantidad*$precio;
                $html .= 
                  "<tr>
                    <td>$titulo</td>
                    <td>$cantidad</td>
                    <td>$precio</td>
                    <td>$temp_total</td>
                  </tr>";
              $total+=$producto['precio']*$producto['cantidad'];
            }
            $itbms=$total*0.07;
          }

          $t=round($total, 2);
          $it=round($itbms, 2);
          $st=round($total+$itbms, 2);
          $html .=
          "
          <tr>
            <td><b>Total:</b></td>
            <td></td>
            <td></td>
            <td><b>$t</b></td>
          </tr>
          <tr>
            <td><b>ITBMS:</b></td>
            <td></td>
            <td></td>
            <td><b>$it</b></td>
          </tr>
          <tr>
            <td><b>Sub-total:</b></td>
            <td></td>
            <td></td>
            <td><b>$st</b></td>
          </tr>
        <tbody>
      </table>
    </div>
  </div>
</div>";
    $pdf = new Dompdf();
    $pdf->set_base_path("../../../html/assets/css/bootstrap.min.css");   
    $pdf->loadHtml($html);
    $pdf->set_option('isHtml5ParserEnabled', true);
    $pdf->set_option('defaultFont', 'Courier');
    $pdf->render();
    $pdf->stream(); 

} catch(PDOException $error) {
  $error= $error->getMessage();
}
?>
