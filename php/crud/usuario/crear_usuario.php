<?php
session_start();
if (isset($_POST['submit'])) {

  $config = include '../../config.php';
  $last_element=null;
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $sentencia = $conexion->prepare("INSERT INTO user (fullname, username, email, password, created_at)
      VALUES (:fn, :un, :em, :pw, :ca)");
    $sentencia->execute(array(
      ':fn' => $_POST['fullname'],
      ':un' => $_POST['username'],
      ':em' => $_POST['email'],
      ':pw' => $_POST['password'],
      ':ca' => date("Y-m-d H:i:s")
    ));

    $last_element = $conexion->lastInsertId();
    $last_element = intval($last_element);

    if(isset($_POST['Roles'])){
      $selected_roles = $_POST['Roles'];
        foreach($selected_roles as $role) {
          //getting the role id
          $stmt_roles = $conexion->prepare("SELECT id FROM roles WHERE role = :role");
          $stmt_roles->execute([':role' => $role]);
          $role_row = $stmt_roles->fetch(PDO::FETCH_ASSOC);
          $role_id = $role_row['id'];
          //echo(var_dump($role_id));
          //echo(var_dump($last_element));

          //inserting into users_roles
          $stmt_users = $conexion->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, :rid)");
          $stmt_users->execute([
            ':uid' => $last_element,
            ':rid' => $role_id
          ]);
        }
    }
    $resultado = ['error' => false, 'mensaje' => 'El usuario ' . $_POST['fullname'] . ' ha sido agregado con éxito'];
  } 
  catch(PDOException $error) {
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

<!--         <div class="form-group">
          <label for="role">Rol</label>
          <select class="form-control" name="role">
            <option disabled selected>Seleccione un rol..</option>
            <option value="1">Administrator</option>
            <option value="2">Cliente</option>
          </select>
        </div> -->
        <div class="form-group">
          <label>Roles</label><br>
          <div class="checkbox-inline">
            <label>
              <input type="checkbox" name="Roles[admin]" value="admin"> Administrador
            </label>
          </div>

          <div class="checkbox-inline">
            <label>
              <input type="checkbox" name="Roles[customer]" value="customer"> Cliente
            </label>
          </div>

          <div class="checkbox-inline">
            <label>
              <input type="checkbox" name="Roles[supervisor]" value="supervisor"> Supervisor
            </label>
          </div>
          
          <div class="checkbox-inline">
            <label>
              <input type="checkbox" name="Roles[software_specialist]" value="software_specialist"> Especialista de software
            </label>
          </div>

          <div class="checkbox-inline">
            <label>
              <input type="checkbox" name="Roles[hardware_specialist]" value="hardware_specialist"> Especialista de hardware
            </label>
          </div>
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
          <a class="btn btn-primary" href="<?= $index_url ?>">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php //include 'templates/footer.php'; ?>