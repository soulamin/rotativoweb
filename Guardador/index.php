<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark" style="min-height:900px ">
                    <div class="card-header">
                        <h3 class="card-title">Guardador</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label>Guardador </label>
                                <select class="form-control" id="Guardador"></select>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-2">
                                <label>Data </label>
                                <input class="form-control" type="date" id="DataEnt">
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-4">
                                <br>
                                <button class="btn  btn-info btn-lg" type="submit" id="btnFechaCaixa">
                                    <i class="fa fa-money"></i> Fechamento de Caixa </button>
                                <br>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <hr>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon "><i class="ion ion-ios-calendar"></i></span>
                                    <div class="info-box-content ">
                                        <span class="info-box-text text-">TOTAL DE TICKETS</span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Hoje : <b class="QtdTicketDiaria"></b></small> </span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Semana : <b class="QtdTicketSemanal"></b></small></span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Mês : <b class="QtdTicketMensal"></b></small> </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                           
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                    <h4 class=" text-center">Ticket Notificado</h2>
                                        <h5 class="TicketNotificado text-center"></h5>
                                    </div>
                                    <span class="small-box-footer text-info">Hoje <i class="fa fa-arrow-circle-up"></i></span>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon "><i class="fa fa-close"></i></span>
                                    <div class="info-box-content ">
                                        <span class="info-box-text">EVASÃO</span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Hoje : <b class="QtdLiberacaoDiariaG"></b></small> </span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Semana : <b class="QtdLiberacaoSemanalG"></b></small></span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Mês : <b class="QtdLiberacaoMensalG"></b></small> </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <!-- ./col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon "><i class="fa fa-money"></i></span>
                                    <div class="info-box-content ">
                                        <span class="info-box-text">TOTAL FATURAMENTO</span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Hoje : <b class="ValorTotalDiaria"></b></small> </span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Semana : <b class="ValorTotalSemanal"></b></small></span>
                                        <span class="info-box-text"><i class="fa fa-calendar"> </i><small> Mês : <b class="ValorTotalMensal"></b></small> </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- ./col -->
                            

                            <div class="col-md-12 col-sm-12 col-xs-12 " >
                                <div class="card card-info " hidden=true id="ExibirRelatorio">
                                    <div class="card-header">
                                        <h3 class="card-title">Relatório</h3>
                                    </div>
                                    <div class="card-body" style="height: 600px">
                                        <iframe id="Relatorio" width="100%" height="80%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="">
                                        </iframe>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <br>

        </div>
    </div>

    </div>

    </div>

    <!------------------------------------Final do Modal---------------------------------------------->

    <?php
    $hr = time();
    include '../layout/footer.php';
    echo '<script src="../controller/GuardadorControllerv3.js?' . $hr . '"></script>';

    ?>