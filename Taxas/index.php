<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <div class="modal fade" id="AlterarTaxas" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success-gradient">
                                            <h5 class="modal-title">Editar Taxas </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                            <input class="form-control " type="hidden"  id="Txt_Codigo">
                                                <div class="col-md-6">
                                                    <label>Tipo Veiculo</label>
                                                    <select class="form-control TipoVeiculo" type="text" id="ATxt_TipoVeiculo">
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tipo de Vaga</label>
                                                    <select class="form-control TipoArea" id="ATxt_Area">
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Valor/Hora</label>
                                                    <input class="form-control Dinheiro" type="text" id="ATxt_Valor">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Qtd. Horas</label>
                                                    <input class="form-control" type="number" min="1" id="ATxt_QtdHora">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-md btn-success" type="submit" id="btnSalvarAlterar"><i class="fa fa-save"></i> Salvar </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Taxas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-success" id="btnTaxa">
                                    <i class="fa fa-plus"></i> Cadastro de Taxas</button>
                            </div>


                            <div class="col-md-12">
                                <br>
                                <table class="table table-bordered table-striped dataTable text-sm" id="TabelaTaxas">
                                    <thead class="bg-dark-gradient">
                                        <th>Tipo de Área</th>
                                        <th>Veículo</th>
                                        <th>Valor</th>
                                        <th>Qtd. Horas</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </thead>
                                    <tbody id="conteudotabela">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!--...................................Modal.......................................-->

                    <div class="modal fade" id="IncluirTaxas" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success-gradient">
                                    <h5 class="modal-title">Cadastro de Taxas </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <form id="FrmSalvarTaxas" method="post" action="" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tipo Veiculo</label>
                                                    <select class="form-control TipoVeiculo" type="text" name="Txt_TipoVeiculo">
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tipo de Vaga</label>
                                                    <select class="form-control TipoArea" name="Txt_Area">
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Valor/Hora</label>
                                                    <input class="form-control Dinheiro" type="text" name="Txt_Valor">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Qtd. Horas</label>
                                                    <input class="form-control" type="number" min="1" name="Txt_QtdHora">
                                                </div>

                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-md btn-success" type="submit" id="btnSalvar"><i class="fa fa-save"></i> Salvar </button>
                                    </div>
                                    </form>
                                    <div class="row">
                                    </div>
                                </div>
                            </div>



                            

                            <!------------------------------------Final do Modal---------------------------------------------->

                            <?php
                            $hr = time();
                            include '../layout/footer.php';
                            echo '<script src="../controller/TaxaControllerv3.js?' . $hr . '"></script>';
                            ?>