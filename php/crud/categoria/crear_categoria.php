<?php
session_start();
if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'la categoria ' . $_POST['categoria'] . ' ha sido agregada con éxito'
  ];

  $config = include '../../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $categoria = [
      "categoria"   => $_POST['categoria'],
    ];

    $consultaSQL = "INSERT INTO categorias ( categoria )";
    $consultaSQL .= "values (:" . implode(", :", array_keys($categoria)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($categoria);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

//navbar url variable path
$index_url = "../../../index.php";
$home_url = "../../../home.php";
$ticket_url = "../ticket/crear_ticket.php";
$user_url = "../usuario/crear_usuario.php";
$category_url = "crear_categoria.php";
$logout_url = "../../logout.php";
?>

<?php include '../../head_resources.php'; ?>
<?php include '../../navbar.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea una categoria</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="categoria">Ingrese una categoria</label>
          <input class="form-control" type="text" name="categoria" ></input>
        </div>
        <div class="form-group my-3">
          <input type="submit" name="submit" class="btn btn-dark" value="Enviar">
          <a class="btn btn-secondary" href="<?= $index_url ?>">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>