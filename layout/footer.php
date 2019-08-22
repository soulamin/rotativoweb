
<!------------------------------------------------------FORMULARIO  INCLUIR  Pátio------------------------------------------------------------------------------>


</section>

</div>

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
              DESEJA RENOVAR ESSE TICKET ?
            </div>
            <div class="modal-footer  text-center">
            <button  class="btn btn-lg btn-success" id="btnRenovaTicket"   codigo="0"  > Sim </button>
                <button  class="btn btn-lg btn-danger" type="submit"  data-dismiss="modal" aria-label="Close" > Não </button>
        </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="AlteraSenha"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success-gradient">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Senha </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Senha Atual</label>
                        <input class="form-control" type="password" PLACEHOLDER="Senha" id="SenhaAtual" >
                    </div>
                    <div class="col-md-12">
                        <label>Senha Nova</label>
                        <input class="form-control" type="password" PLACEHOLDER="Senha" id="SenhaNova" >
                    </div>
                    <div class="col-md-12 text-right">
                        <br>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-lg btn-success" type="submit" id="BtnAltSenha" ><i class="fa fa-save"></i> Alterar </button>
            </div>
        </div>
    </div>
</div>

<footer class="main-footer bg-gray">
    <div class="float-right d-none ">
        <b>Version</b> 2.0.0
    </div>
    <strong>Brtec Copyright &copy; 2019 <a href="#">Rotativo Digital</a>.</strong>
</footer>
</div>

<!-- jQuery -->
<script src="../plugins/jQuery/jquery.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<!-- JqueryForm -->
<script src="../js/jquery.form.js"></script>

<script src="../js/jquery.maskMoney.js"></script>
<!-- DataTables -->
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- FastClick -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="../plugins/fastclick/fastclick.min.js"></script>
<script src="../controller/MenuControllerv3.js"></script>


<script>
$(document).ready(function(){
   
    NotificaVencido();
    });


        function NotificaVencido(){
            $.post("../model/Ticket.php",{
                    acao : 'Busca_Ticket'
                }, function(data) {
                    $('.GerenciaTickets').html(data['Html']);
                    if(data['Cod_Error']>=1){
                        var indica ='<span class="badge badge-danger navbar-badge btnGerenciar">'+ data['Cod_Error']+'</span>'
                       
                        $('#QtdVenc').html(indica);
                        if (Android) {
                            Android.sendbeep("1");
                            //Android.showToast(JSON.stringify(data['Msg']));

                        }
                        
                    }else{
                        
                        var indica =' ';
                        $('#QtdVenc').html(indica);
                        if (Android) {
                            Android.sendbeep("0");
                          //  Android.showToast(JSON.stringify(data['Msg']));

                        }
                       
                    }
                },
                "json"
            );
        }
        var temp=setInterval(NotificaVencido,10000);
</script>
<section>
</body>
</html>
