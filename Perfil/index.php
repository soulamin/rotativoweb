
<?php include '../layout/header.php';?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Perfil</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                        <div class="col-md-12">
                        <input type="hidden" class="form-control" id='ATxt_Codigo' name='ATxt_Codigo' >
                                            <label>Nome</label>
                                            <input type="text" class="form-control" id='ATxt_Nome' name='ATxt_Nome' >
                                        </div>

                                        <div class="col-md-4">
                                            <label>Email</label>
                                            <input class="form-control " type="email"   id ='ATxt_Email' name ='ATxt_Email' >
                                        </div>

                                        <div class="col-md-4">
                                            <label>Celular </label>
                                            <input class="form-control Celular" type="text"   id ='ATxt_Celular' name ='ATxt_Celular' >
                                        </div>

                                        <div class="col-md-4">
                                            <label>Login </label>
                                            <input class="form-control" type="text"   id ='ATxt_Login' name ='ATxt_Login'>
                                        </div>
                                        <div class="col-md-4">
                                            <label>CPF </label>
                                            <input class="form-control Cpf" type="text" id ='ATxt_Cpf' name ='Atxt_Cpf'>
                                        </div>
                                        <div class="col-md-10 text-right  ">
                                        <button  class="btn btn-lg btn-success  " type="submit" id="btnSalvarPerfil" ><i class="fa fa-check"></i> Atualizar </button>
                                          <br>
                                        </div>
                                        <div class="col-md-12">
                                        <hr>
                                        </div>
                                        <div class="col-md-4">
                                        <br>
                                        <div class="input-group ">
                                        <input class="form-control Placa" type="text" id='Txt_Placa'>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-warning  btn-flat" id="btnAddPlaca"><i class="fa fa-plus"></i> Placa </button>
                                        </span>
                                         </div>
                                         </div>
                                        <div class="col-md-12">
                                           <label class=" text-lg text-danger">Minhas Placas</label>
                                           <span class="MinhasPlacas"></span>
                                        </div>
                        

                    </div>

                                </div>
                        </div>
                    </div>

        <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
        </section>
    </div>
    <!-- /.content-wrapper -->

<?php
$hr=time();
include '../layout/footer.php';
echo '<script src="../controller/PerfilControllerv3.js?'.$hr.'"></script>';
?>

