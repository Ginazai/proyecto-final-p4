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

    $consulta = $conexion->prepare("UPDATE user SET fullname = :fn, username = :un,
      email = :em, password = :pw WHERE id = :id");
    $consulta->execute(array(
      ':id' => $_GET['id'],
      ':fn' => $_POST['fullname'],
      ':un' => $_POST['username'],
      ':em' => $_POST['email'],
      ':pw' => $_POST['password']
    ));

    $update_role_query1 = $conexion->prepare("DELETE FROM user_roles WHERE user_id = :uid");
    $update_role_query1->execute(array(':uid' => $_GET['id']));

    if(isset($_POST['Roles'])){
      foreach($_POST['Roles'] as $role){
        $select_role = $conexion->prepare("SELECT id FROM roles WHERE role = :role");
        $select_role->execute([":role" => $role]);
        $selected_row = $select_role->fetch(PDO::FETCH_ASSOC);
        $selected_id = $selected_row['id'];

        $reinsert_role_query = $conexion->prepare("INSERT INTO user_roles (user_id, role_id)
          VALUES (:uid, :rid)");
        $reinsert_role_query->execute([
          ":uid" => $_GET['id'],
          "rid" => $selected_id
        ]);
      }
    }

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];

  $sentencia = $conexion->prepare("SELECT * FROM user WHERE id = :id");
  $sentencia->execute(array(
    ':id' => $id
  ));
  $usuario = $sentencia->fetch(PDO::FETCH_ASSOC); /**@return selected user*/

  /**
   * Search for all the user roles
   * */
  $roles=array();
  $role_names=array();
  $role_query = $conexion->prepare("SELECT * FROM user_roles WHERE user_id = :uid");
  $role_query->execute(array(
    ':uid' => $id
  ));
  while($role_row=$role_query->fetch(PDO::FETCH_ASSOC)){
    array_push($roles, $role_row['role_id']);
  }
  /**
   * Get the name from the roles DB
   * */
  foreach($roles as $role){
    $role_query2 = $conexion->prepare("SELECT role FROM roles WHERE id = :rid");
    $role_query2->execute(array(
      ':rid' => $role
    ));
    $role_name = $role_query2->fetch(PDO::FETCH_ASSOC);
    $role_name = $role_name['role'];
    array_push($role_names, $role_name);
  }
  
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

<!--           <div class="form-group">
            <label for="role">Rol</label>
            <select class="form-control" name="role" value="">
              <option disabled>Seleccione un rol..</option>
              <option value="1">Administrator</option>
              <option value="2">Cliente</option>
            </select>
          </div> -->

          <div class="form-group">
            <label>Roles</label><br>
            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[admin]" value="admin" <?= in_array("admin", $role_names) ? "checked" : "" ?>> Administrador
              </label>
            </div>

            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[customer]" value="customer" <?= in_array("customer", $role_names) ? "checked" : "" ?>> Cliente
              </label>
            </div>

            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[supervisor]" value="supervisor" <?= in_array("supervisor", $role_names) ? "checked" : "" ?>> Supervisor
              </label>
            </div>
            
            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[software_specialist]" value="software_specialist" <?= in_array("hardware_specialist", $role_names) ? "checked" : "" ?>> Especialista de software
              </label>
            </div>

            <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="Roles[hardware_specialist]" value="hardware_specialist" <?= in_array("software_specialist", $role_names) ? "checked" : "" ?>> Especialista de hardware
              </label>
            </div>
          </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="<?= $usuario['email'] ?>" class="form-control" >
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" name="password" id="password" value="<?= $usuario['password'] ?>" class="form-control">
            </div>

            <div class="form-group">
              <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
              <a class="btn btn-primary" href="../../../index.php">Regresar al inicio</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
}
?>