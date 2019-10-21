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
                                                <input class="form-control " type="date" name="DataEnt" id='DataEnt'>
                                        </div>
                                        <div class=" col-md-4 col-sm-12">
                                                <select class="form-control" id='Tipo'>
                                                    <option value="Placa" selected >PLACA</option>
                                                    <option value="codTicket">TICKET</option>
                                                </select>
                                            </div>
                                            <div class=" col-md-4 col-sm-12">
                                                    <div class="input-group ">
                                                        <input class="form-control Placa" type="text" name="Dados" id='Dados'>
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat" id="btnPesquisaPlaca"><i class="fa fa-search"></i> Pesquisar </button>
                                                        </span>
                                            </div>
                                </div>
                                   
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


</div>
                    </div>

                    
<!--------------------------------------------------------- Modal ------------------------------------------------------------------------>
<div class="modal fade" id="AlteraLocal"  tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" >
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
                                                        <input class="form-control " type="hidden" id='ATxt_IdTicket'  name='Txt_IdTicket' >
                                                        <select class="form-control Local" name='IdLocalFiscal'>
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
                   
<!--------------------------------------------------------- Modal ------------------------------------------------------------------------>
<div class="modal fade" id="ModalPgNot"  tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" >
                                <div class="modal-content">
                                    <div class="modal-header bg-success-gradient">
                                        <h5 class="modal-title" id="exampleModalLabel16">Pagamento</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body ">
                                                    <div class='row'>
                                                    <div class="col-sm-3  text-right">
                                                        <button class='btn btn-warning ' id="QtdTicketDia"></button>
                                                    </div>

                                                        <div class="col-sm-3">
                                                        <input  type="hidden" id='IdTicket' >
                                                            <label>Hora Ent. </label>
                                                            <input class="form-control " type="text" id='HoraEnt' disabled >
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label>Hora Saída </label>
                                                            <input class="form-control " type="text" id='HoraSaida' disabled >
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label>Pecorrido  </label>
                                                            <input class="form-control " type="text" id='Tempo' disabled >
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label>Valor  </label>
                                                            <input class="form-control " type="text" id='Valor' disabled>
                                                        </div>
                                                    </div>
                                                    
                                    </div>
                                    <div class="modal-footer  text-center">
                                        <label>DESEJA EFETUAR PAGAMENTO ?</label>
                                            <button  class="btn btn-lg btn-success PagarFracao"   ><i class="fa fa-check"></i> Sim </button>
                                            <button  class="btn btn-lg btn-danger"   data-dismiss="modal" aria-label="Close" ><i class="fa fa-close"></i> Não </button>
                                           
                                   </div>
                                </div>
                            </div>
                        </div>
<!-------------------------------------------------------------- Modal ---------------------------------------------------------------->
<!-- Modal -->
<div class="modal fade" id="ConfirmaLiberacao"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-gradient">
                <h5 class="modal-title" id="exampleModalLabel1">Informa </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
              DESEJA  TICKET DE NOTIFICAÇÃO PARA PAGAMENTO FRAÇÃO ?
            </div>
            <div class="modal-footer  text-center">
            <button  class="btn btn-lg btn-success" id="btnRenovaTicket"   codigo="0"  > Sim </button>
                <button  class="btn btn-lg btn-danger" type="submit"  data-dismiss="modal" aria-label="Close" > Não </button>
        </div>
        </div>
    </div>
</div>
<!-- Modal -->
        <!-------------------------------------------------------------- Modal --------------------------------------------------------------------->
 
<div class="modal " id="IncluirTicket" >
    <div class="modal-dialog  modal-dialog-scrollable" >
        <div class="modal-content">
                        <div class="modal-header bg-success-gradient">
                                        <h5 class="modal-title" > Ticket Notificado </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                        </div>
                        <div class="modal-body ">

                            <form id="FrmSalvarTicket" method="post" action="" enctype="multipart/form-data">
                            <input class="form-control IdTime" type="hidden" id='Txt_DataCriacao' name='Txt_DataCriacao' readonly>

                                <div class="col-md-12 ">
                                   <input class="form-control " id='Txt_LocalFiscal' type="hidden" name='Txt_LocalFiscal' readonly>                            
                                    <label>Placa</label>
                                    <input class="form-control " type="text" id='Txt_Placa' name='Txt_Placa' readonly>
                                </div>
                                   
                              <div class="col-md-12 Taxas hide"></div>
                                <input class="form-control" value='1' type="hidden" name='Txt_Evasao'>
                                <input class="form-control" id="Taxas"  value='' type="hidden" name='Txt_Taxa'>
                                <input class="form-control" id="Valor" value='2.00' type="hidden" name='Txt_Valor'>
                               
                                    </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-lg btn-success btn-block" type="submit" id="btnSalvar">
                                                <i class="fa fa-print"></i> Imprimir </button>
                                        
                                                <button class="btn btn-lg btn-danger btn-block" type="submit"  data-dismiss="modal" aria-label="Close" class="close">
                                                <i class="fa fa-close"></i> Cancelar </button>
                                            </form> 
                                        </div>
                     
                                </div>
                        </div>
                    </div>
        <!------------------------------------------------------------ Modal ------------------------------------------------------------------------>

    <?php
        $hr = time();
        include '../layout/footer.php';
        echo '<script src="../controller/GerenciaTicketControllerv3.js?' . $hr . '"></script>';
        ?>