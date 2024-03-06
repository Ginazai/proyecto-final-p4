<?php
$error = false;
$config = include 'php/config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT * FROM user WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM user";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuarios = $sentencia->fetchAll();
  /**
   * consultar roles de usuario
   * **/
  $role_id = null;
  if($usuarios && $sentencia->rowCount() > 0){
    foreach($usuarios as $row){
      $user_id = $row['id'];

      $consultaRoles = "SELECT * FROM users_roles WHERE user_id = $user_id";
      $sentencia2 = $conexion->prepare($consultaRoles);
      $sentencia2->execute();

      while($r=$sentencia2->fetch(PDO::FETCH_ASSOC)) {
        $role_id = $r['role_id'];

        $query_role = "SELECT role FROM roles WHERE id = $role_id";
        $sentencia3 = $conexion->prepare($query_role);
        $sentencia3->execute();

        while($r2=$sentencia3->fetch(PDO::FETCH_ASSOC)) {
          $role_name = $r2['role'];
          break;
        }
        break;
      }
    }
  }

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de usuarios (' . $_POST['apellido'] . ')' : 'Lista de usuarios ';
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
            <th>Nombre Completo</th>
            <th>Nombre de Usuario</th>
            <th>Email</th>
            <th>Password</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($usuarios && $sentencia->rowCount() > 0) {
            foreach ($usuarios as $fila) {
              //prevent user from editing himself
              if($fila['id'] == $_SESSION['user_id']) {continue;}
              ?>
              <tr>
                <td><?php echo $fila["id"]; ?></td>
                <td><?php echo $fila["fullname"]; ?></td>
                <td><?php echo $fila["username"]; ?></td>
                <td><?php echo $fila["email"]; ?></td>
                <td><?php echo $fila["password"]; ?></td>
                <td><?php echo $role_name; ?></td>
                <td>
                  <a href="<?= 'php/crud/usuario/borrar_usuario.php?id=' . $fila["id"] ?>">🗑️Borrar</a>
                  <a href="<?= 'php/crud/usuario/editar_usuario.php?id=' . $fila["id"] ?>">✏️Editar</a>
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