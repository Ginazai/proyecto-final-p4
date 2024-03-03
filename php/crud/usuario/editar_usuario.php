<?php
session_start();
$config = include '../../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El usuario no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = [
      "id"        => $_GET['id'],
      "fullname"    => $_POST['fullname'],
      "username"  => $_POST['username'],
      "email"     => $_POST['email'],
      "password"    => $_POST['password'],
      "role"    => $_POST['role']
    ];
    
    $consultaSQL = "UPDATE user SET
        fullname = :fullname,
        username = :username,
        email = :email,
        password = :password,
        role = :role
        WHERE id = :id";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($usuario);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM user WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$usuario) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el usuario';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

//navbar url variable path
$index_url = "../../../index.php";
$home_url = "../../../home.php";
$ticket_url = "../ticket/crear_ticket.php";
$user_url = "crear_usuario.php";
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
          El usuario ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($usuario) && $usuario) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el usuario <?= $usuario['fullname'] ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="fullname">Nombre completo</label>
            <input type="text" name="fullname" id="fullname" value="<?= $usuario['fullname'] ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input type="text" name="username" id="username" value="<?= $usuario['username'] ?>" class="form-control">
          </div>

          <div class="form-group">
            <label for="role">Rol</label>
            <select class="form-control" name="role" value="<?= $usuario['role'] ?>">
              <option disabled>Seleccione un rol..</option>
              <option value="1">Administrator</option>
              <option value="2">Cliente</option>
            </select>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $usuario['email'] ?>" class="form-control">
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="text" name="password" id="password" value="<?= $usuario['password'] ?>" class="form-control">
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