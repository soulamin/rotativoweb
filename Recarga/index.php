<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-dark" style="min-height:900px ">
                    <div class="card-header">
                        <h3 class="card-title">Compra</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row ">
                            <div class="col-xs-6 col-md-6 text-sm text-muted">
                                Ambiente Seguro <i class="fa fa-lock text-gray"></i>
                            </div>
                            <div class="col-md-6 text-right col-xs-6">
                                        <label id="Saldo" class="btn btn-outline-danger"></label>
                            </div>     
                       </div>
                       <div class="row ">
                        
                          <div class="col-md-4 col-sm-12 ">
                                   
                                    <select  class="form-control TCartao"  ></select>
                          </div>
                          <div class="col-md-3 col-sm-12 NToken">
                                <button class="btn  btn-danger  btn-block" id="btnExcluir"> 
                                   <i class="fa fa-trash"></i> Excluir   </button>
                          </div>
                       </div>
                 
                       <div class="row ">
                               
                                <div class="col-md-6 col-sm-12 NCartao ">
                                    <label>Nº Cartão </label>
                                    <input class="form-control Cartao" type="text" id='Txt_Cartao'>
                                </div>
                                <div class="col-md-6 col-sm-12 NCartao">
                                    <label>Nome</label>
                                    <input class="form-control text-uppercase" type="text" id='Txt_Nome'>

                                </div>
                                <div class="col-md-3 col-sm-4 ">
                                    <label>Cod. Verificador</label>
                                    <input class="form-control cod" type="text" id='Txt_Cod'>
                                </div>

                                <div class="col-md-3 col-sm-4 NCartao">
                                    <label>Validade</label>
                                    <input class="form-control Val" type="text" id='Txt_Validade'>
                                </div>
                                <div class="col-md-12 ">
                                    <label class='text-primary'>Selecione o Valor :</label>
                                </div>
                                <div class="col-md-12 ">
                                    <span class="Recarga"></span>
                                    <input class="form-control " type="hidden" value='0.00' id='Txt_Recarga'>
                                </div>
                                <div class="col-md-4 col-sm-12  NCartao">
                                        <button class="btn btn-lg btn-success btn-block" id="btnRecargaPg">
                                        <i class="fa fa-check"></i> Recarga </button>
                                </div>
                                <div class="col-md-4 col-sm-12 NToken">
                                        <button class="btn btn-lg btn-success btn-block" id="btnRecargaTk">
                                        <i class="fa fa-check"></i> Recarga </button>
                                </div>
                                <div class="col-md-4 col-sm-12 ">
                                         <button class="btn btn-lg btn-primary btn-block" id="btnLimpar"> 
                                         <i class="fa fa-eraser"></i> Limpar </button>
                                </div>
                         </div>
                     
                <!-- /.table-responsive -->
              </div>
             
            </div>
                            <!-- /.card-body -->
                        </div>
                        <!--...................................Modal.......................................-->
                        <div class="modal fade" id="FalhaDados" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning-gradient">
                                        <h5 class="modal-title">Informa </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center bg-warning text-lg">
                                        <i class="fa fa-ok"></i>
                                        Por favor Preencher os Dados!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                    </div>
                </div>
                <!--...................................Modal.......................................-->
                <div class="modal fade" id="loader" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img class="img" src="../figuras/loading.gif">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <!--...................................Modal.......................................-->
                <div class="modal fade" id="PgAprovado" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success-gradient">
                                <h5 class="modal-title">Informa </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center bg-success text-lg">
                                <i class="fa fa-ok"></i>
                                Pagamento Realizado com Sucesso!
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <!--...................................Modal.......................................-->
                <div class="modal fade" id="PgNaoAprovado" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger-gradient">
                                <h5 class="modal-title">Informa </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center bg-danger text-lg">
                                <i class="fa fa-ok"></i>
                                Pagamento Não Autorizado!
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->

                <?php
                $hr = time();
                include '../layout/footer.php';
                echo '<script src="../controller/RecargaControllerv3.js?' . $hr . '"></script>';
                ?>