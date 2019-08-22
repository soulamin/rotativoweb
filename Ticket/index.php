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
                        <form id="FrmSalvarTicket" method="post" action="" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <label>ID</label>
                                <input class="form-control IdTime" type="text" id='Txt_DataCriacao' name='Txt_DataCriacao' readonly>
                            </div>
                            <div class="col-md-12">
                                <label>Local</label>
                                <select class="form-control Local" name='Txt_LocalFiscal'>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Placa</label>
                                <input class="form-control Placa" type="text" name='Txt_Placa'>
                            </div>
                            <div class="col-md-12">
                                <label>Tipo de Veiculo</label>
                                <select class="form-control TipoVeiculo" name='Txt_TipoVeiculo'>
                                </select>
                            </div>
                            <!--   <div class="col-md-12 hidde">
                                <label>Marca/Modelo</label>
                                <input class="form-control MarcaModelo" type="text" disabled>
                            </div>
                            <div class="col-md-12">
                                <label>Cor</label>
                                <input class="form-control Cor" type="text" disabled>
                            </div>-->

                            <div class="col-md-12">
                                <label>Data/Hora Entrada</label>
                                <input class="form-control DataHoraEnt" type="text" name='Txt_DataHoraEnt' readonly>
                            </div>
                            <input class="form-control" id="Taxas" type="hidden" name='Txt_Taxa'>
                            <input class="form-control" id="Valor" type="hidden" name='Txt_Valor'>
                            <div class="col-md-12 ">
                                <label class="text-primary text-lg">Período</label>
                            </div>
                            <div class="col-md-12 Taxas"></div>

                            <div class="col-md-12">
                                <label>Data/Hora Saída</label>
                                <input class="form-control DataHoraSaida" type="text" name='Txt_DataHoraSaida' readonly>
                                <input type="hidden" name="Txt_Evasao" id="Txt_Evasao" value="0">
                            </div>

                            <div class="col-md-12">
                                <label>Forma de Pagamento</label>
                                <select class="form-control" name='Txt_FormaPg'>
                                    <option value='D' selected>DINHEIRO</option>
                                   
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-4  col-sm-4">
                                    <button class="btn btn-lg btn-success btn-block" id="btnSalvar">
                                        <i class="fa fa-print"></i> Imprimir </button>
                                </div>
                                <div class=" col-md-4  col-sm-4">
                                    <button class="btn btn-lg btn-primary btn-block" id="btnLimpar">
                                        <i class="fa fa-eraser"></i> Limpar </button>
                                </div>
                                <div class=" col-md-4  col-sm-4">
                                    <button class="btn btn-lg btn-warning btn-block" id="btnEvasao">
                                        <i class="fa fa-ban"></i>Pagamento Pendente </button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>


    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="PeriodoVigente" tabindex="-1" role="dialog" aria-labelledby="periodovigente" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success-gradient">
                    <h5 class="modal-title" id="periodovigente">Informa </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Veículo em Período Vigente !<br>
                    Deseja Alterar Localidade?
                    <div class="col-md-12 FormAlteraLocal  text-left" hidden="true">
                        <label>Local</label>
                        <select class="form-control Local" id='Txt_ALocalFiscal'>
                        </select>
                        <button class="btn btn-warning"  id="BtnAltLocalidade"> Alterar Local </button>
                    </div>
                </div>
                <div class="modal-footer  text-center">
                    <button class="btn btn-lg btn-success" id="btnAlteraLocal"> Sim </button>
                    <button class="btn btn-lg btn-danger" type="submit" data-dismiss="modal" aria-label="Close"> Não </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <!------------------------------------Final do Modal---------------------------------------------->

    <?php
    $hr = time();
    include '../layout/footer.php';
    echo '<script src="../controller/TicketControllerv3.js?' . $hr . '"></script>';
    ?>