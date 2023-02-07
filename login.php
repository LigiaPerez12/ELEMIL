<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LOGIN</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

      
</head>

<body class="hold-transition login-page" style="background-color:#17A2B8;">
  <div class="login-box">
    <div class="login-logo">
    <img class="animation__shake" src="admin/dist/img/elemil.png" height="30" width="30">
      <b>ELEMIL </b>WATER
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Iniciar Sesión</p>
        <?php
        if (isset($_REQUEST['login'])) {
          session_start();
          $email = $_REQUEST['email'] ?? '';
          $pasword = $_REQUEST['pass'] ?? '';
          $pasword = md5($pasword);
          include_once "admin/db.ventas.php";
          $con = mysqli_connect($host, $user, $pass, $db);
          $query = "SELECT id,email,nombre from clientes where email='" . $email . "' and pass='" . $pasword . "';  ";
          $res = mysqli_query($con, $query);
          $row = mysqli_fetch_assoc($res);
          if ($row) {
            $_SESSION['idCliente'] = $row['id'];
            $_SESSION['emailCliente'] = $row['email'];
            $_SESSION['nombreCliente'] = $row['nombre'];
            header("location: index.php?mensaje=Usuario registrado exitosamente");
          } else {
        ?>
            <div class="row justify-content-center" role="alert">
              Error de login 
               <img src="admin/dist/img/error.png" width="20">
            </div>
        <?php
          }
        }
        ?>
        <br>
        <form method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="pass">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row justify-content-between">
            <!-- /.col -->
            <div class="col-2">
            </div>
            <div class="col-8">
              <button type="submit" class="btn btn-outline-info" name="login">Iniciar sesión</button>
              <a href="registro.php" class="btn btn-outline-success" >Registrarse</a>
            </div>
            <div class="col-2">   
            </div>

            <!-- /.col -->
          </div>
        </form>

        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="admin/dist/js/adminlte.min.js"></script>

</body>

</html>