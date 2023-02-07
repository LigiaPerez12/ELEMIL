<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LOGIN ADMIN</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page" style="background-color:#17A2B8;">
  <div class="login-box">
    <div class="login-logo">
    <img class="animation__shake" src="dist/img/elemil.png" height="40" width="30">
      <b>ELEMIL </b>WATER
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Ingresar</p>
        <?php
        if (isset($_REQUEST['login'])) {
          session_start();
          $email = $_REQUEST['email'] ?? '';
          $pasword = $_REQUEST['pass'] ?? '';
          $pasword = md5($pasword);
          include_once "db.ventas.php";
          $con = mysqli_connect($host, $user, $pass, $db);
          $query = "SELECT id,email,nombre from usuarios where email='" . $email . "' and pass='" . $pasword . "';  ";
          $res = mysqli_query($con, $query);
          $row = mysqli_fetch_assoc($res);
          if ($row) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['nombre'] = $row['nombre'];
            header("location: panel.php");
          } else {
        ?>
            <div class="alert alert-danger" role="alert">
            </div>
        <?php
          }
        }
        ?>
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
            <div class="col-2"></div>
            <div class="col-5">
              <button type="submit" class="btn btn-outline-info" name="login">Iniciar Sesión</button>
            </div>
            <div class="col-2"></div>
            <!-- /.col -->
          </div>
        </form>

        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

</body>

</html>