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
                                <div class="row">
                                    <div class="col-md-2">
                                        <select class="form-control "  id='Tipo'>
                                            <option value="Placa" selected>PLACA</option>
                                            <option value="codTicket">TICKET</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        
                                    <input class="form-control " type="date" name="DataEnt" id='DataEnt'>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group ">
                                            <input class="form-control " type="text" name="Dados" id='Dados'>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-warning btn-flat" id="btnPesquisaPlaca"><i class="fa fa-search"></i> Pesquisar </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                    
                                    <label>Resultado da Pesquisa</label>
                                    <hr>
                                    <div class="row PesquisaPlaca"></div>
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