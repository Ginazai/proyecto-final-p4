<nav class="navbar navbar-default" role="navigation">
<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?= $home_url ?>"><b>Helpdesk</b></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <?php if(!isset($_SESSION["user_id"])):?>
      <li><a href="./registro.php">REGISTRO</a></li>
      <li><a href="./login.php">LOGIN</a></li>
    <?php elseif(in_array(1, $_SESSION['role'])):?>
      <li><a href="<?= $index_url  ?>">Inicio</a></li>
      <li><a href="<?= $ticket_url  ?>">Crear ticket</a></li>
      <li><a href="<?= $user_url  ?>">Crear usuario</a></li>
      <li><a href="<?= $category_url ?>">Crear categoria</a></li>
      <li><a href="<?= $logout_url ?>">SALIR</a></li>
    <?php else:?>
      <li><a href="<?= $logout_url ?>">SALIR</a></li>
    <?php endif;?>
    </ul>

  </div><!-- /.navbar-collapse -->
</div>
</nav>