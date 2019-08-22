<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-dark" style="min-height:900px ">
                    <div class="card-header">
                        <h3 class="card-title">Ticket</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="col-md-12 text-right">
                                <label class="btn btn btn-outline-danger" id="Saldo"></label>
                               
                    </div>
                        <form id="FrmSalvarTicket" method="post" action="" enctype="multipart/form-data">
                            
                            <div class="col-md-12">
                                <label>TICKET</label>
                                <input class="form-control IdTime" type="text" id='Txt_DataCriacao' name='Txt_DataCriacao' readonly>
                            </div>
                            <div class="col-md-12">
                                <label>Local</label>
                                <select class="form-control Local" name='Txt_LocalFiscal'>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Placa</label>
                                <select class="form-control PlacaUsuario" type="text" name='Txt_Placa'>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Tipo de Veiculo</label>
                                <select class="form-control TipoVeiculo" name='Txt_TipoVeiculo'>
                                </select>
                            </div>
                          
                            <div class="col-md-12">
                                <label>Data/Hora Entrada</label>
                                <input class="form-control DataHoraEnt" type="text" name='Txt_DataHoraEnt' readonly>
                                <br>
                            </div>

                            <div class="col-md-12 ">
                                <label class="text-primary text-lg">Período</label>
                            </div>
                            <div class="col-md-12 Taxas"></div>
                            <input class="form-control" id="Taxas" type="hidden" name='Txt_Taxa'>
                            <input class="form-control" id="Valor" type="hidden" name='Txt_Valor'>

                            <div class="col-md-12">
                                <label>Data/Hora Saída</label>
                                <input class="form-control DataHoraSaida" type="text" name='Txt_DataHoraSaida' readonly>
                                <input type="hidden" name="Txt_Evasao"  id="Txt_Evasao"  value="0">
                        </div>
                                <input class="form-control" value="C" type="hidden" name='Txt_FormaPg'>
                                <div class="row">
                                    <div class="col-md-4  col-sm-4">
                                        <button class="btn btn-lg btn-success btn-block"  id="btnSalvar">
                                            <i class="fa fa-check"></i> Concluir </button>
                                    </div>
                                    <div class=" col-md-4  col-sm-4">
                                        <button class="btn btn-lg btn-warning btn-block"  id="btnLimpar">
                                            <i class="fa fa-eraser"></i> Limpar </button>
                                    </div>
                                  
                                </div>
                            </div>

                    </form>
                </div>

            </div>

        </div>


    </div>
    </div>

    <!------------------------------------Final do Modal---------------------------------------------->

    <?php
    $hr = time();
    include '../layout/footer.php';
    echo '<script src="../controller/MeuTicketControllerv3.js?' . $hr . '"></script>';
    ?>