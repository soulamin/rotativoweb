<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="row">
                    <div class="col-md-12">
                        <div class="card card-dark" style="min-height:900px ">
                            <div class="card-header">
                                <h3 class="card-title">Consultar Tickets</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class=" col-md-4 col-sm-12">
                                    <select class="form-control" id='Tipo'>
                                        <option value="Placa" selected >PLACA</option>
                                        <option value="codTicket">TICKET</option>
                                    </select>
                                        <div class="input-group ">
                                            <input class="form-control Placa" type="text" name="Dados" id='Dados'>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-info btn-flat" id="btnPesquisaPlaca"><i class="fa fa-search"></i> Pesquisar </button>
                                            </span>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <div class="row PesquisaPlaca "><br></div>
                                <h5 class="text-danger text-bold">Tickets Pendentes </h5>
                                <hr>
                                <div class="row GerenciaTickets "><br></div>

                                <h5 class="text-warning text-bold">Tickets Notificados</h5>
                                <hr>
                                <div class="row TicketsNotificados"><br></div>
                            </div>
                        </div>
                    </div>
 <!-- Modal -->
 <div class="modal fade" id="IncluirTicket" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success-gradient">
                            <h5 class="modal-title" >Renovar Ticket </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body ">

                            <form id="FrmSalvarTicket" method="post" action="" enctype="multipart/form-data">
                            <input class="form-control IdTime" type="hidden" id='Txt_DataCriacao' name='Txt_DataCriacao' readonly>

                                <div class="col-md-12">
                                <input class="form-control " id='Txt_LocalFiscal' type="hidden" name='Txt_LocalFiscal' readonly>
                                                                      
                                    <label>Placa</label>
                                    <input class="form-control " type="text" id='Txt_Placa' name='Txt_Placa' readonly>
                                </div>
                                    <input class="form-control" type="hidden" name='Txt_TipoVeiculo'>
                                    <input class="form-control MarcaModelo" type="hidden" type="text" disabled>
                                    <input class="form-control Cor" type="hidden" type="text" disabled>
                            
                                <div class="col-md-12">
                                    <label>Data/Hora Entrada</label>
                                    <input class="form-control DataHoraEnt" type="text" name='Txt_DataHoraEnt' readonly>
                                    <br>
                                </div>
                                <div class="col-md-12 ">
                                <label class="text-primary text-lg">Período</label>
                                </div>
                            <div class="col-md-12 Taxas"></div>
                                <input class="form-control" value='0' type="hidden" name='Txt_Evasao'>
                                <input class="form-control" id="Taxas" type="hidden" name='Txt_Taxa'>
                                <input class="form-control" id="Valor" type="hidden" name='Txt_Valor'>
                                <div class="col-md-12">
                                    <label>Data/Hora Saída</label>
                                    <input class="form-control DataHoraSaida" type="text" name='Txt_DataHoraSaida' readonly>
                                </div>
                                    <div class="col-md-12">
                                    <label>Forma de Pagamento</label>
                                    <select class="form-control" name='Txt_FormaPg'>
                                        <option value='D' selected>DINHEIRO</option>
                                        <option value='C'>DÉBITO/CRÉDITO</option>
                                    </select>
                                    
                                        <div class="col-md-6 col-sm-6">
                                            <button class="btn btn-lg btn-success btn-block" type="submit" id="btnSalvar">
                                                <i class="fa fa-print"></i> Imprimir </button>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                                <button class="btn btn-lg btn-danger btn-block" type="submit" class="close">
                                                <i class="fa fa-close"></i> Cancelar </button>
                                        </div>
                                        </form>
                                    
                                </div>
                        </div>
                        
                   
    
                   
        <!-- Modal -->

<!-- Modal -->
                        <div class="modal fade" id="AlteraLocal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel16" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success-gradient">
                                        <h5 class="modal-title" id="exampleModalLabel16">Alterar Local </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body ">
                                             <form id="FrmAlterarLocal" method="post" action="" enctype="multipart/form-data">
                                                    
                                                    <div class="col-md-12">
                                                        <label>Local</label>
                                                        <input class="form-control " type="hidden" id='Txt_IdTicket'  name='Txt_IdTicket' >
                                                        <select class="form-control Local" name='Txt_LocalFiscal'>
                                                        </select>
                                                    </div>
                                    </div>
                                        <div class="modal-footer  text-center">
                                            <button  class="btn btn-lg btn-success AlterarLocalidade" type="submit"   ><i class="fa fa-check"></i> Alterar </button>
                                            <button  class="btn btn-lg btn-danger" type="submit"  data-dismiss="modal" aria-label="Close" ><i class="fa fa-close"></i> Fechar </button>
                                                </form>
                                        </div>
                                </div>
                            </div>
                        </div>
<!-- Modal -->
</div>
                    </div>
        <?php
        $hr = time();
        include '../layout/footer.php';
        echo '<script src="../controller/GerenciaTicketControllerv3.js?' . $hr . '"></script>';
        ?>