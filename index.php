<html>
<head>
  <meta charset= "UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>::Rotativo Digital::</title>


  <link rel="shortcut icon" href="figuras/favicon.ico" type="image/x-icon">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
  <!-- Bootstrap 3.3.5 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Ion Slider -->
    <link rel="stylesheet" href="plugins/ionslider/ion.rangeSlider.css">
    <!-- ion slider Nice -->
    <link rel="stylesheet" href="plugins/ionslider/ion.rangeSlider.skinNice.css">
    <!-- bootstrap slider -->
    <link rel="stylesheet" href="plugins/bootstrap-slider/slider.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition login-page bg-success-gradient" >

<div id="msg"></div>
<div class="login-box" style="background-color:rgba(255,253,253,0.9);">
  <div class="login-logo">

  </div>
  <!-- /.login-logo -->
  <div class="login-box-body"  >
    <p class="login-box-msg ">
       <div class="row">
          <div class="col-md-12 text-center">
            <img src="figuras/logo.png"  width="80%" >
          </div>
       </div>
    </p>

    <form id="FrmLogar" action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="Txt_Login"  placeholder="LOGIN">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="Txt_Senha"  placeholder="SENHA">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
         <!-- /.col -->
        <div class="col-md-12">
          <button type="submit" id="btnEntrar" class="btn btn-dark btn-block ">
            ENTRAR
          </button>
            <br>
        </div>
            <div class="col-xs-12 text-right">

              <a href="#"><b> <!--ESQUECI MINHA SENHA --></b></a>

            </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">

    </div>
    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>

<!-- SparkLine -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.2 -->
<script src="plugins/chartjs-old/Chart.min.js"></script>
<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- JqueryForm -->
<script src="js/jquery.form.js"></script>
<!-- DataTables -->
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<script src="controller/LoginControllerv3.js"></script>


</body>
</html>
