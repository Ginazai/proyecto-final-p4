<?php
session_start();
if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El usuario ' . $_POST['fullname'] . ' ha sido agregado con éxito'
  ];

  $config = include '../../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = [
      "fullname"   => $_POST['fullname'],
      "username" => $_POST['username'],
      "email"    => $_POST['email'],
      "password"    => $_POST['password']
    ];

    $consultaSQL = "INSERT INTO user (fullname, username, email, password)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($usuario)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($usuario);

    /**
     * @joint roles a usuarios
     * **/
    $stmt = $conexion->prepare("INSERT INTO users_roles VALUES(:uid, :rid)");
    $stmt->execute(array(
      ':uid' = $
    ));

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
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
      <h2 class="mt-4">Crea un usuario</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="fullname">Nombre completo</label>
          <input type="text" name="fullname" id="fullname" class="form-control">
        </div>
        <div class="form-group">
          <label for="username">Nombre de usuario</label>
          <input type="text" name="username" id="username" class="form-control">
        </div>

        <div class="form-group">
          <label for="role">Rol</label>
          <select class="form-control" name="role">
            <option disabled selected>Seleccione un rol..</option>
            <option value="1">Administrator</option>
            <option value="2">Cliente</option>
          </select>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="<?= $home_url ?>">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php //include 'templates/footer.php'; ?>