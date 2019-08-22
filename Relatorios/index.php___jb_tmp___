<?php include '../layout/header.php';?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-dark" style="min-height:900px ">
                        <div class="card-header">
                            <h3 class="card-title">Relatório</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form  method="post" action="../RelatorioMensal/index.php" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-md-2">
                                    <label>Data Inicial</label>
                                    <input class="form-control" type="date"  name='Txt_DataInicial' >
                                </div>
                                <div class="col-md-2">
                                    <label>Data Final</label>
                                    <input class="form-control" type="date"  name='Txt_DataFim' >
                                </div>

                                        <button  class="btn  btn-info " type="submit" id="btnBaixarInfo" >
                                            <i class="fa fa-download"></i> Baixar Informações </button>
                                </form>
                            </div>

                        </div>


                    </div>

                        </div>

                        </div>


  <!--...................................Modal.......................................-->

<div class="modal fade" id="IncluirFiscal"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient">
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
                                <label>Fiscal</label>
                                <select class="form-control Fiscal"  name='Txt_Fiscal'>
                                </select>
                            </div>
                                <div class="col-md-2">
                                    <label>Cep</label>
                                    <input class="form-control Cep"  name='Txt_Cep' >
                                </div>

                                <div class="col-md-10">
                                    <label>Logradouro</label>
                                    <input class="form-control Rua"  name='Txt_Logradouro' >
                                </div>

                                <div class="col-md-5">
                                    <label>Bairro</label>
                                    <input class="form-control Bairro"   name='Txt_Bairro' >
                                </div>
                                <div class="col-md-5">
                                    <label>Cidade</label>
                                    <input class="form-control Cidade"   name='Txt_Cidade'>
                                </div>
                                <div class="col-md-2">
                                    <label>Uf</label>
                                    <input class="form-control Uf"  id='ATxt_Uf' name='Txt_Uf'>
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

<?php
$hr=time();
include '../layout/footer.php';
echo '<script src="../controller/RelatorioControllerv3.js?'.$hr.'"></script>';
?>