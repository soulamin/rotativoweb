<?php include '../layout/header.php';?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-dark" style="min-height:900px ">
                        <div class="card-header">
                            <h3 class="card-title">Pagamento Pendente de  Tickets</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                                <div class="row">

                                <div class="col-md-12 col-sm-12">
                                    <br>
                                      <table class="table table-bordered table-striped dataTable text-sm table-responsive-sm"  id="TabelaEvasao">
                                          <thead class="bg-success-gradient" >

                                              <th >Placa</th>
                                              <th >Data Hora </th>
                                              <th >Status </th>
                                              <th ></th>

                                          </thead>
                                          <tbody id="conteudotabela">
                                          </tbody>
                                      </table>
                                </div>
                            </div>

                        </div>

  <!--...................................Modal.......................................-->

<div class="modal fade" id="TicketInfo"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-gradient">
                <h5 class="modal-title" >Informações de Ticket </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="row">


                        <div class="row">
                                <div class="col-md-3">
                                    <label>Ticket </label>
                                    <span id="Txt_Ticket" class="form-control"></span>
                                </div>
                                <div class="col-md-2">
                                    <label>Placa</label>
                                    <span id="Txt_Placa" class="form-control"></span>
                                </div>

                                <div class="col-md-3">
                                    <label>Data/Hora Entrada</label>
                                    <span id="Txt_DataHoraEntrada" class="form-control"></span>
                                </div>

                                <div class="col-md-3">
                                    <label>Data/Hora Saída</label>
                                    <span id="Txt_DataHoraSaida" class="form-control"></span>
                                </div>

                                 <div class="col-md-4">
                                    <label>Fiscal</label>
                                     <span id="Txt_Fiscal" class="form-control"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Localidade</label>
                                    <span id="Txt_Localidade" class="form-control"></span>
                                </div>
                                <div class="col-md-2">
                                    <label>Valor</label>
                                    <span id="Txt_Valor" class="form-control"></span>
                                </div>
                            </div>

                        </div>
                    </div>

    </div>
    </div>


    <div class="modal fade" id="IncluirTicket" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary-gradient">
                            <h5 class="modal-title" >Renovar Ticket </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body ">

                            <form id="FrmSalvarTicket" method="post" action="" enctype="multipart/form-data">
                            <input class="form-control IdTime" type="text" id='Txt_DataCriacao' name='Txt_DataCriacao' readonly>

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

                                <div class="col-md-12 Taxas">
                                    <div class="divider"></div>
                                    <br>
                                </div>
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
                                    <div class="modal-footer ">
                                        <div class="col-md-6 col-sm-6">
                                            <button class="btn btn-lg btn-success btn-block" type="submit" id="btnSalvar">
                                                <i class="fa fa-print"></i> Imprimir </button>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                                <button class="btn btn-lg btn-danger btn-block" type="submit" class="close">
                                                <i class="fa fa-close"></i> Cancelar </button>
                                        </div>
                                        
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Modal -->



  <!------------------------------------Final do Modal---------------------------------------------->

<?php
$hr=time();
include '../layout/footer.php';
echo '<script src="../controller/EvasaoControllerv3.js?'.$hr.'"></script>';
?>