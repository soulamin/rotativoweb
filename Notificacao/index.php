<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-dark" style="min-height:900px ">
                    <div class="card-header">
                        <h3 class="card-title">Notificação</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header bg-warning">
                                    <h3 class="card-title">Consulta Placa</h3>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="display: block;">
                                    <select class="form-control " hidden='true' id='Tipo'>
                                        <option value="Placa" selected>PLACA</option>
                                        <option value="codTicket">TICKET</option>
                                    </select>

                                    <div class="input-group ">
                                        <input class="form-control Placa" type="text" name="Dados" id='Dados'>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-warning btn-flat" id="btnPesquisaPlaca"><i class="fa fa-search"></i> Pesquisar </button>
                                        </span>
                                    </div>
                                    
                                    <label>Resultado da Pesquisa</label>
                                    <hr>
                                    <div class="row PesquisaPlaca"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                        <div class="col-md-12">
                            <div class="card  card-outline">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title ">Cadastrar Notificação</h3>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="display: block;">
                                <form id="FrmSalvarNotificacao" method="post" action="" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <label>Local</label>
                                <select class="form-control Localidade" name='Txt_Local'>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Placa</label>
                                <input class="form-control Placa" type="text" name='Txt_Placa'>

                            </div>
                            <div class="col-md-12">
                                <label>Motivo</label>
                                <select class="form-control TipoNoticacao" name='Txt_TipoNot'>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-4  col-sm-4">
                                    <button class="btn btn-lg btn-success btn-block" id="btnSalvar">
                                        <i class="fa fa-check"></i> Concluir </button>
                                </div>
                                <div class=" col-md-4  col-sm-4">
                                    <button class="btn btn-lg btn-primary btn-block" id="btnLimpar">
                                        <i class="fa fa-eraser"></i> Limpar </button>
                                </div>
                            </div>
                    </div>

                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>



                      
                </div>

            </div>

        </div>


    </div>
    </div>

    <!------------------------------------Final do Modal---------------------------------------------->

    <?php
    $hr = time();
    include '../layout/footer.php';
    echo '<script src="../controller/NotificacaoControllerv3.js?' . $hr . '"></script>';
    ?>