<?php
$error = false;
$config = include 'php/config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT * FROM categorias WHERE categoria LIKE '%" . $_POST['categoria'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM categorias";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $categoria = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['categoria']) ? 'Lista de tickets (' . $_POST['categoria'] . ')' : 'Lista de categorias ';
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
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($categoria && $sentencia->rowCount() > 0) {
            foreach ($categoria as $fila) {
              ?>
              <tr>
                <td><?php echo $fila["id"]; ?></td>
                <td><?php echo $fila["categoria"]; ?></td>
                <td>
                  <a href="<?= 'php/crud/categoria/borrar_categoria.php?id=' . $fila["id"] ?>">🗑️Borrar</a>
                  <a href="<?= 'php/crud/categoria/editar_categoria.php?id=' . $fila["id"] ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>