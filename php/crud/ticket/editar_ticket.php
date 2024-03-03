<?php
session_start();
$config = include '../../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El ticket no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $ticket = [
      "id"        => $_GET['id'],
      "nombre"    => $_POST['nombre'],
      "apellido"  => $_POST['apellido'],
      "email"     => $_POST['email'],
      "consulta" => $_POST['consulta']
    ];
    
    $consultaSQL = "UPDATE tickets SET
        nombre = :nombre,
        apellido = :apellido,
        email = :email,
        consulta = :consulta,
        created_at = created_at,
        updated_at = NOW()
        WHERE id = :id";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($ticket);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM tickets WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $ticket = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$ticket) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el ticket';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
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
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El ticket ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($ticket) && $ticket) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el ticket <?= $ticket['ticket'] ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= $ticket['nombre'] ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?= $ticket['apellido'] ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $ticket['email'] ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="edad">Consulta</label>
            <input type="text" name="consulta" id="consulta" value="<?= $ticket['consulta'] ?>" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="../../../home.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php //require "templates/footer.php"; ?>