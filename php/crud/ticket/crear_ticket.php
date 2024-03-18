<?php
session_start();
if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El ticket ha sido generado con éxito'
  ];

  $config = include '../../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $ticket = [
      "nombre"   => $_POST['nombre'],
      "apellido" => $_POST['apellido'],
      "email"    => $_POST['email'],
      "ticket"     => hash("sha256", $_POST['nombre'].$_POST['apellido'].$_POST['email']),
      "consulta" => $_POST['consulta']
    ];

    $consultaSQL = "INSERT INTO tickets (nombre, apellido, email, ticket, consulta)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($ticket)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($ticket);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

//navbar url variable path
$index_url = "../../../index.php";
$home_url = "../../../home.php";
$ticket_url = "crear_ticket.php";
$user_url = "../usuario/crear_usuario.php";
$category_url = "../categoria/crear_categoria.php";
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
      <h2 class="mt-4">Crea un ticket</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" name="apellido" id="apellido" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="consulta">Consulta</label>
          <textarea class="form-control" id="consulta" name="consulta"></textarea>
        </div>
        <div class="form-group my-3">
          <input type="submit" name="submit" class="btn btn-dark" value="Enviar">
          <a class="btn btn-secondary" href="<?= $index_url ?>">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php //include '../../templates/footer.php'; ?>