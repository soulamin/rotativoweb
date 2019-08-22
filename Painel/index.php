<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark" style="min-height:900px ">
                    <div class="card-header">
                        <h3 class="card-title">Painel</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                    <div class="row">
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
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 class="TicketMedio text-center"></h3>
                                </div>
                                <span class="small-box-footer">TICKET MÉDIO <i class="fa fa-arrow-circle-up"></i></span>
                            </div>
                        </div>
                    </div>
                  

                        <form method="post" action="../RelatorioMensal/index.php" enctype="multipart/form-data">
                           <div class="row">
                            <div class="col-md-4">
                                <label>Fiscal</label>
                                <select class="form-control Fiscal" name='Txt_Fiscal'></select>
                            </div>    
                            <div class="col-md-2">
                                <label>Data Inicial</label>
                                <input class="form-control" type="date" name='Txt_DataInicial'>
                            </div>
                            <div class="col-md-2"> 
                                <label>Data Final</label>
                                <input class="form-control" type="date" name='Txt_DataFim'>
                            </div>
                            <button class="btn  btn-info " type="submit" id="btnBaixarInfo">
                                <i class="fa fa-download"></i> Baixar Informações </button>
                                </form>
                    </div>
                    <br>
                    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

                </div>
            </div>
            
    </div>
    
    </div>

    <!------------------------------------Final do Modal---------------------------------------------->

    <?php
    $hr = time();
    include '../layout/footer.php';
    echo '<script src="../controller/PainelControllerv3.js?' . $hr . '"></script>';

    ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>