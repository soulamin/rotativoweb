
<?php include '../layout/header.php';?>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-black">
                    <div class="box-header with-border bg-black-active">
                        <h1 class="box-title "> Forma de Pagamento</h1>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button  class="btn btn-lg bg-navy" id="btnFormaPg">
                                    <i class="fa fa-plus"></i> Incluir Forma Pagamento</button>
                            </div>
                            <br>
                        </div>
                        <fieldset>
                            <legend>
                                <label>Resultado de Busca</label>
                            </legend>
                        </fieldset>
                        <div class="row">
                            <div class="box-body">
                                <table id="TabelaFormaPg" class="table table-bordered  table-hover table-responsive text-center text-sm">
                                    <thead class="bg-primary" >
                                    <tr>
                                        <th class="text-center" >Forma de Pagamento</th>
                                        <th class="text-center" >Sigla</th>
                                        <th class="text-center" >Status</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody id="conteudotabela">
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------------FORMULARIO  INCLUIR  Pátio------------------------------------------------------------------------------>

        <div class="modal" id="IncluirFormaPg" >

            <div class="modal-dialog modal-lg ">

                <div class="modal-content">

                    <div class="modal-header bg-black">

                        <button type="button" class="close text-gray" data-dismiss="modal"  aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title text-white"> Incluir Forma de Pagamento</h3>
                    </div>

                    <div class="modal-body" style="color: black">
                        <!--- recebe a mensagem de retorno ---->
                        <div class='msg'></div>
                        <legend> Dados</legend>

                        <div class="row">

                            <form id="FrmSalvarFormaPg" method="post" action="" enctype="multipart/form-data">

                                <div class="col-md-5">
                                    <label>Forma de Pagamento</label>
                                    <input class="form-control"  name='Txt_FormaPg' >
                                </div>
                                <div class="col-md-2">
                                    <label>Sigla</label>
                                    <input class="form-control"  name='Txt_Sigla' >
                                </div>
                        </div>
                        <br>

                        <fieldset>
                            <legend> Opções</legend>
                            <div class="row">

                                <div class="col-md-12 text-center">
                                    <button  class="btn btn-lg btn-success" id="btnSalvar"><i class="fa fa-save"></i> Salvar </button>
                                    <button  class="btn btn-lg btn-default"  data-dismiss="modal"><i class="fa fa-close"></i>	Fechar</button>
                                </div>

                            </div>
                        </fieldset>
                        </form>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal-dialog -->
        <!--------------------------------------------------------FIM FORMULARIO INCLUIR----------------------------------------------------------------------------------!>

        <!------------------------------------------------------FORMULARIO Agente Fiscalizador EDITAR ------------------------------------------------------------------------------>

        <div class="modal" id="AlterarFormaPg" >

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header bg-black-gradient">

                        <button type="button" class="close text-gray" data-dismiss="modal"  aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title" > Alterar Forma de Pagamento</h3>
                    </div>

                    <div class="modal-body">
                        <!--- recebe a mensagem de retorno ---->
                        <div class='msg'></div>
                        <legend> Dados</legend>

                        <div class="row">

                            <form id="FrmAlterarFormaPg" method="post" action="" enctype="multipart/form-data">

                                <div class="col-md-5" >
                                    <input class="form-control" type="hidden" id='Txt_Codigo' name='Txt_Codigo' >
                                        <label>Forma de Pagamento</label>
                                        <input class="form-control"  name='ATxt_FormaPg'  id='ATxt_FormaPg' >

                                </div>
                                <div class="col-md-2">
                                    <label>Sigla</label>
                                    <input class="form-control"  name='ATxt_Sigla'  id='ATxt_Sigla' >
                                </div>
                        </div>
                        <br>

                        <fieldset>
                            <legend> Opções</legend>
                            <div class="row">

                                <div class="col-md-12 text-center">
                                    <button  class="btn btn-lg btn-success" id="btnAlterar"><i class="fa fa-save"></i> Alterar </button>
                                    <button  class="btn btn-lg btn-default"  data-dismiss="modal"><i class="fa fa-close"></i>	Fechar</button>
                                </div>

                            </div>
                        </fieldset>
                        </form>

                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
    </section>
</div>
<!-- /.content-wrapper -->
<?php include '../layout/footer.php'; ?>
    <script src="../controller/FormaPgControllerv3.js"></script>