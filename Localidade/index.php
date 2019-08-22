<?php include '../layout/header.php';?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-dark" style="min-height:900px ">
                        <div class="card-header">
                            <h3 class="card-title">Localidade</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button  class="btn btn-md btn-success" id="btnLocalidade">
                                            <i class="fa fa-plus"></i> Cadastro de Localidade</button>
                                    </div>


                                <div class="col-md-12">
                                    <br>
                                      <table class="table table-bordered table-striped dataTable text-sm"  id="TabelaFiscal">
                                          <thead class="bg-dark-gradient" >
                                              <th >Rua</th>
                                              <th >Qtd. Vagas</th>
                                              <th >Status</th>
                                              <th >Ação</th>
                                          </thead>
                                          <tbody id="conteudotabela">
                                          </tbody>
                                      </table>
                                </div>
                            </div>

                        </div>

  <!--...................................Modal.......................................-->

<div class="modal fade" id="IncluirLocalidade"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-gradient">
                <h5 class="modal-title" >Cadastro de Localidade </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="row">

                    <form id="FrmSalvarLocalidade" method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                                          
                                <div class="col-md-2">
                                    <label>Cep</label>
                                    <input class="form-control Cep"  type="text" name='Txt_Cep' >
                                </div>

                                <div class="col-md-10">
                                    <label>Logradouro</label>
                                    <input class="form-control Rua" type="text" name='Txt_Logradouro' >
                                </div>

                                <div class="col-md-4">
                                    <label>Bairro</label>
                                    <input class="form-control Bairro" type="text"  name='Txt_Bairro' >
                                </div>
                                <div class="col-md-4">
                                    <label>Cidade</label>
                                    <input class="form-control Cidade" type="text"  name='Txt_Cidade'>
                                </div>
                                <div class="col-md-2">
                                    <label>Uf</label>
                                    <input class="form-control Uf" type="text"  name='Txt_Uf'>
                                </div>
                                <div class="col-md-2">
                                    <label>Qtd. Vagas</label>
                                    <input class="form-control"  name='Txt_QtdVagas' value='1' type="number" min="1">
                                    
                                </div>
                            </div>
                                <div class="modal-footer ">
                                    <button  class="btn btn-lg btn-success" type="submit" id="btnSalvar" >
                                        <i class="fa fa-save"></i> Salvar </button>
                                </div>
                            </form>
                        </div>
                    </div>
              </div>
          </div>

  <!------------------------------------Final do Modal---------------------------------------------->
  
    </div>
    </div>
<!--...................................Modal.......................................-->

<div class="modal fade" id="AlterarLocalidade"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-gradient">
                <h5 class="modal-title" >Cadastro de Localidade </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="row">

                    <form id="FrmAlterarLocalidade" method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                        <input class="form-control"  type="hidden" name='Txt_Codigo' id='Txt_Codigo'>
                                <div class="col-md-2">
                                    <label>Cep</label>
                                    <input class="form-control Cep"  type="text" id='ATxt_Cep'  name='ATxt_Cep' >
                                </div>

                                <div class="col-md-10">
                                    <label>Logradouro</label>
                                    <input class="form-control Rua" type="text"  id='ATxt_Endereco'  name='ATxt_Logradouro' >
                                </div>

                                <div class="col-md-4">
                                    <label>Bairro</label>
                                    <input class="form-control Bairro" type="text"  id='ATxt_Bairro'  name='ATxt_Bairro' >
                                </div>
                                <div class="col-md-4">
                                    <label>Cidade</label>
                                    <input class="form-control Cidade" type="text"   id='ATxt_Cidade'  name='ATxt_Cidade'>
                                </div>
                                <div class="col-md-2">
                                    <label>Uf</label>
                                    <input class="form-control Uf" type="text" id='ATxt_Uf'  name='ATxt_Uf'>
                                </div>
                                <div class="col-md-2">
                                    <label>Qtd. Vagas</label>
                                    <input class="form-control" id='ATxt_QtdVagas'  name='ATxt_QtdVagas' value='1' type="number" min="1">
                                    
                                </div>
                            </div>
                                <div class="modal-footer ">
                                    <button  class="btn btn-lg btn-success" type="submit" id="btnAlterar" >
                                        <i class="fa fa-save"></i> Alterar </button>
                                </div>
                            </form>
                        </div>
                    </div>

  <!------------------------------------Final do Modal---------------------------------------------->
<?php
$hr=time();
include '../layout/footer.php';
echo '<script src="../controller/LocalidadeControllerv3.js?'.$hr.'"></script>';
?>