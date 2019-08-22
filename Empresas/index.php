<?php include '../layout/header.php';?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Empresas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-12">
                                <br>
                                <table class="table table-bordered table-striped dataTable text-sm"  id="TabelaEmpresas">
                                    <thead class="bg-dark-gradient" >
                                    <tr>
                                        <th class="text-center" >Empresa</th>
                                        <th class="text-center" >Status</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody id="conteudotabela">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!--...................................Modal.......................................-->

                    <div class="modal fade" id="AlterarEmpresa"  tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success-gradient">
                                    <h5 class="modal-title" >Cadastro de Empresas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <form id="FrmAlterarEmpresa" method="post" action="" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <p id="Logo"></p>
                                                </div>

                                                <input type="hidden" hidden id='Txt_Codigo' name='Txt_Codigo'>
                                                <div class="col-md-9">
                                                    <label>Empresa</label>
                                                    <input class="form-control" PLACEHOLDER="NOME EMPRESA" id='ATxt_Nome' name='ATxt_Nome'>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Cnpj</label>
                                                    <input class="form-control CNPJ"   PLACEHOLDER="CNPJ"  id ='ATxt_Cnpj' name ='ATxt_Cnpj'>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                    <input class="form-control " type="email"  PLACEHOLDER="EMAIL" id ='ATxt_Email' name ='ATxt_Email' >
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Telefone</label>
                                                    <input class="form-control Telefone" PLACEHOLDER="TELEFONE" id='ATxt_Telefone' name='ATxt_Telefone' >
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Celular</label>
                                                    <input class="form-control Celular" PLACEHOLDER="CELULAR" id='ATxt_Celular' name='ATxt_Celular' >
                                                </div>

                                                <div class="col-md-2">
                                                    <label>Cep</label>
                                                    <input class="form-control CEP" PLACEHOLDER="CEP"  id='ATxt_Cep' name='ATxt_Cep' >
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Logradouro</label>
                                                    <input class="form-control Rua" PLACEHOLDER="ENDEREÇO" id='ATxt_Logradouro' name='ATxt_Logradouro' >
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Numero</label>
                                                    <input class="form-control" type="number" PLACEHOLDER="NÚMERO" id='ATxt_Numero' name='ATxt_Numero' >
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Compl.</label>
                                                    <input class="form-control"  PLACEHOLDER="COMPLEMENTO" id='ATxt_Compl' name='ATxt_Compl' >
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Bairro</label>
                                                    <input class="form-control Bairro"  PLACEHOLDER="BAIRRO" id='ATxt_Bairro' name='ATxt_Bairro' >
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Cidade</label>
                                                    <input class="form-control Cidade"  PLACEHOLDER="CIDADE" id='ATxt_Cidade' name='ATxt_Cidade'>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Uf</label>
                                                    <input class="form-control Uf"  PLACEHOLDER="UF" id='ATxt_Uf' name='ATxt_Uf'>
                                                </div>


                                            </div>
                                            <br>


                                </div>
                                <div class="modal-footer">
                                    <button  class="btn btn-md btn-success" type="submit" id="btnAlterar" ><i class="fa fa-save"></i> Alterar </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
        </section>
    </div>
    <!-- /.content-wrapper -->

<?php
$hr=time();
include '../layout/footer.php';
echo '<script src="../controller/EmpresaControllerv3.js?'.$hr.'"></script>';
?>
