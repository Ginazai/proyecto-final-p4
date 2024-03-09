<?php
$error = false;
$config = include 'php/config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['usuarios'])) {
    $consultaSQL = "SELECT * FROM user WHERE fullname LIKE '%" . $_POST['usuarios'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM user";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuarios = $sentencia->fetchAll();
  /**
   * consultar roles de usuario
   * **/
  
  if($usuarios && $sentencia->rowCount() > 0){
    foreach($usuarios as $usuario){
      
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
            //roles selection
            foreach ($usuarios as $fila) {
              //prevent user from editing himself
              //if($fila['id'] == $_SESSION['user_id']) {continue;}
              ?>
              <tr>
                <td><?php echo $fila["id"]; ?></td>
                <td><?php echo $fila["fullname"]; ?></td>
                <td><?php echo $fila["username"]; ?></td>
                <td><?php echo $fila["email"]; ?></td>
                <td><?php echo $fila["password"]; ?></td>
                <td>
                  <?php 
                  $user_id = $fila['id'];

                  $get_relation = $conexion->prepare("SELECT * FROM user_roles WHERE user_id = :uid");
                  $get_relation->execute([':uid' => $user_id]);
                  while($relation_row=$get_relation->fetch(PDO::FETCH_ASSOC)){
                    $role_id = $relation_row['role_id'];

                    $get_role_name = $conexion->prepare("SELECT role FROM roles WHERE id = :rid");
                    $get_role_name->execute([':rid' => $role_id]);
                    $role_names=$get_role_name->fetchAll();
                    foreach($role_names as $name){
                      echo($name['role'] . "<br>");
                    }
                  }
                  ?>
                </td>
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