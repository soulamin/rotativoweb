<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-dark" style="min-height:900px ">
                    <div class="card-header">
                        <h3 class="card-title">Informações Tickets</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <h5 class="text-danger text-bold">Tickets Pendentes </h5>
                        <hr>
                        <div class="row GerenciaTickets"><br></div>
                    

                        <div class="col-md-12 col-sm-12">

                            <br>
                            <table class="table table-bordered table-striped dataTable text-sm " id="TabelaHistorico">
                                <thead class="bg-dark-gradient">

                                    <th>Placa</th>
                                    <th>Data Hora </th>
                                    <th>Ação</th>

                                </thead>
                                <tbody id="conteudotabela">
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <div class="modal fade" id="TicketInfo" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary-gradient">
                                    <h5 class="modal-title">Informações de Ticket </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class='row'>
                                <div class="modal-body">
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

                                        <div class="col-md-3">
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

  </div>  </div>
                                </div>
                            </div>
                            <!--...................................Modal.......................................-->



                            <?php
                            $hr = time();
                            include '../layout/footer.php';
                            echo '<script src="../controller/HistoricoControllerv3.js?' . $hr . '"></script>';
                            ?>