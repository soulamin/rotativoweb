<?php include '../layout/header.php';?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
<!--...................................Modal.......................................-->


  <!------------------------------------Final do Modal---------------------------------------------->

                <div class="col-md-12">

                    <div class="card card-dark " style="min-height:900px ">
                        <div class="card-header">
                            <h3 class="card-title"> Local Fiscal</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button  class="btn btn-md bg-success" id="btnFiscal">
                                            <i class="fa fa-plus"></i> Cadastro de Local Fiscal</button>
                                    </div>


                                <div class="col-md-12">
                                    <br>
                                      <table class="table table-bordered table-striped dataTable text-sm"  id="TabelaFiscal">
                                          <thead class="bg-dark-gradient" >
                                              <th >Nome</th>
                                              <th >Email</th>
                                              <th >Status</th>
                                              <th >Ação</th>
                                          </thead>
                                          <tbody id="conteudotabela">
                                          </tbody>
                                      </table>
                                </div>
                            </div>
 <!--...................................Modal.......................................-->

 <div class="modal fade" id="IncluirFiscal"  tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success-gradient">
                            <h5 class="modal-title" >Cadastro de Local Fiscal </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">

                                <form id="FrmSalvarLocalFiscal" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label>Local</label>
                                                <select class="form-control Local"  name='Txt_Local'>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Fiscal</label>
                                                <select class="form-control Fiscal"  name='Txt_Fiscal'>
                                                </select>
                                            </div>
                                           
                                    </div>
                               
                           </div>
                           <div class="modal-footer">
                                                <button  class="btn btn-lg btn-success" type="submit" id="btnSalvar" >
                                                    <i class="fa fa-save"></i> Salvar </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
  <!------------------------------------Final do Modal---------------------------------------------->

                        </div>
                        <div class="modal fade" id="EditarLocalFiscal"  tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success-gradient">
                            <h5 class="modal-title" >Alterar Local Fiscal </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">

                                <form id="FrmAlterarLocalFiscal" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label>Local</label>
                                                <select class="form-control Local"   id='ATxt_Local' name='ATxt_Local'>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Fiscal</label> 
                                                <select class="form-control Fiscal" id='ATxt_Fiscal' name='ATxt_Fiscal'>
                                                </select>
                                            </div>
                                           
                                    </div>
                               
                           </div>
                           <div class="modal-footer">
                                                <button  class="btn btn-lg btn-success" type="submit" id="btnSalvar" >
                                                    <i class="fa fa-save"></i> Alterar </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
  <!--...................................Modal.......................................-->

            <div class="modal fade" id="IncluirFiscal"  tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success-gradient">
                            <h5 class="modal-title" >Cadastro de Local Fiscal </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">

                                <form id="FrmSalvarLocalFiscal" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label>Local</label>
                                                <select class="form-control Local"  name='Txt_Local'>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Fiscal</label>
                                                <select class="form-control Fiscal"  name='Txt_Fiscal'>
                                                </select>
                                            </div>
                                           
                                    </div>
                               
                           </div>
                           <div class="modal-footer">
                                                <button  class="btn btn-lg btn-success" type="submit" id="btnSalvar" >
                                                    <i class="fa fa-save"></i> Salvar </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
  <!------------------------------------Final do Modal---------------------------------------------->

<?php
$hr=time();
include '../layout/footer.php';
echo '<script src="../controller/LocalFiscalControllerv3.js?'.$hr.'"></script>';
?>