<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>::Rotativo Digital::</title>

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#053e05">
  <meta name="msapplication-TileImage" content="/mstile-144x144.png">
  <meta name="theme-color" content="#04481c">
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
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition login-page bg-success-gradient">

  <div id="msg"></div>

    <!------------------------------------------------------- Fim do Formulario cadastro --------------------------------------------------------------------------------------------->
    <div class="modal fade " id="IncluirUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="exampleModalLabel">
          <div class="modal-header bg-success-gradient">
            <h5 class="modal-title">Cadastro de Usuário </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <form id="FrmSalvarUsuario" method="post" action="" enctype="multipart/form-data">
                <div class="row  text-dark">

                  <div class="col-md-12 col-xs-12">
                    <label>Nome</label>
                    <input class="form-control" type="text" name='Txt_Nome'>
                  </div>

                  <div class="col-md-4 col-xs-12">
                    <label>Email</label>
                    <input class="form-control" type="email" name='Txt_Email'>
                  </div>
                  <div class="col-md-4  col-xs-12">
                    <label>CPF</label>
                    <input class="form-control CPF" type="text" name='Txt_Cpf'>
                  </div>
                  <input class="form-control Telefone" value='0' type="hidden" name='Txt_Telefone'>

                  <div class="col-md-4 col-xs-6">
                    <label>Celular</label>
                    <input class="form-control Celular" type="text" name='Txt_Celular'>
                  </div>

                  <div class="col-md-4 col-xs-6">
                    <label>Login</label>
                    <input class="form-control" name='Txt_Login'>
                  </div>

                  <div class="col-md-5 col-xs-6 input-group">
                    <label>Senha</label><br>
                    <input class="form-control " type="password" name='Txt_Senha'>
                    <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                  </div> 
                    </div>

                  <div class="col-md-4">
                    <label>Placa</label>
                    <input class="form-control Placa" type="text" name='Txt_Placa'>
                  </div>

                  <input class="form-control " type="hidden" value="U" name="Txt_Tipo">

                </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-md btn-success" type="submit" id="btnSalvar">
                <i class="fa fa-save"></i> Salvar </button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!------------------------------------------------------- Fim do esq --------------------------------------------------------------------------------------------->

  <div class="login-box" style="background-color:rgba(255,253,253,0.9);">
    <div class="login-logo">

    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg ">
        <div class="row">
          <div class="col-md-12 text-center">
            <img src="figuras/logo.png" width="80%">
          </div>
        </div>
      </p>

      <form id="FrmLogar" action="" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" id="Txt_Login" placeholder="LOGIN">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" id="Txt_Senha" placeholder="SENHA">          
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">

          <!-- /.col -->
          <div class="col-md-12">

            <button type="submit" id="btnEntrar" class="btn btn-dark btn-block ">
              ENTRAR
            </button>
      </form>
      <br>
    </div>
    <div class="col-md-12  col-sm-12 text-center">
      <label data-toggle="modal" data-target="#EsqueciaSenha"> <a href="#">Esqueci a Senha ?</a></label>
      <label> | <label>
          <label data-toggle="modal" data-target="#IncluirUsuario"> <a href="#" class="text-success">Quero me Cadastrar. </a></label>
    </div>
  </div>
  </div>
  <!----------------------------------------------------------- Formulario de Cadastro ------------------------------------------------>
  <div class="modal fade " id="EsqueciaSenha" tabindex="-1" role="dialog" aria-labelledby="example12" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="example12">
          <div class="modal-header bg-success-gradient">
          <h5 class="modal-title">Esqueci a Senha </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            
              <div class="col-md-12 col-xs-12 text-dark">
                <label>Digite seu email Cadastrado</label>
                <input class="form-control" type="email" id='ETxt_Email'>
              </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-md btn-warning" type="submit" id="btnEnviarEmail">
              <i class="fa fa-send"></i> Enviar </button>
          </div>
        </div>
      </div>
    
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="dist/js/demo.js"></script>
    <!-- SparkLine -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jquery/jquery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- InputMask -->
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