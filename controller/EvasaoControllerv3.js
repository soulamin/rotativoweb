/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/

tabelaBuscaHistorico=null;
$(".Celular").inputmask({
    mask : ["(99)9999-9999", "(99)99999-9999"],
    keepStatic : true
});
$(".Placa").inputmask({
	mask : ["AAA9999", "AAA9A99"],
	keepStatic : true
});
$(".Val").inputmask("99/9999");
$(".CPF").inputmask("999.999.999-99");
$(".Cartao").inputmask("9999.9999.9999.9999");
$(".Telefone").inputmask("(99)9999-9999");
$(".CEP").inputmask("99999-999");


/*=======================================================================================
*
*
* CALL INITIALIZE
*
*
=======================================================================================*/

/*=======================================================================================
*
*
* ACTIONS
*
*
=======================================================================================*/
//inicializa a tabela
$(document).ready(function() {
	instanciaTabelaBusca();
	BuscaHistoricoTabela();
	BotaoRecarga();
});


//Botão para  Evasao
$(document).off("click", ".btnEvasao");
$(document).on("click", ".btnEvasao", function() {
    Evasao($(this).attr('codigo'));
});


//Botão para  Pagamento
$(document).off("click", ".btnPagar");
$(document).on("click", ".btnPagar", function() {
    Pagamento($(this).attr('codigo'));
});


//Botão para  Liberar Vaga
$(document).off("click", "#btnRenovaTicket");
$(document).on("click", "#btnRenovaTicket", function() {
    BuscaTicketInfo($(this).attr('codigo'));
   
});

//Botão para  Recarga
$(document).off("click", "#btnRecargaPg");
$(document).on("click", "#btnRecargaPg", function() {
    PagamentosRecarga();
   
});

//Botão para  Liberar Vaga
$(document).off("click", ".btnLiberarVaga");
$(document).on("click", ".btnLiberarVaga", function() {
   $('#ConfirmaLiberacao').modal('show');
  $('#btnRenovaTicket').attr("codigo",$(this).attr('codigo'));
   LiberarVaga($(this).attr('codigo'));

});

//Busca Tabela status
$(document).off("click", ".btnInfoTicket");
$(document).on("click", ".btnInfoTicket", function() {
    InfoTicket($(this).attr('codigo'));
});

//busca  cadastrada  para a combobox
function BuscaTicket() {
    $.post('../model/Ticket.php', {
        acao : 'Busca_Ticket',
    }, function(data) {
        $('.GerenciaTickets').html(data['Html']);
    }, "json");

}


/*=======================================================================================
 *
 *
 * FUNCTIONS
 *
 *
 =======================================================================================*/
function instanciaTabelaBusca() {

    if (tabelaBuscaHistorico != null) {
		tabelaBuscaHistorico.destroy();
		tabelaBuscaHistorico = null;
    } else {
		tabelaBuscaHistorico = $('#TabelaEvasao').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
            },
            "processing": true,
			"autoFill": true,
            "responsive": true,
            "paging" : true,
            "lengthChange" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "autoWidth" : true
        });
    }
}

function BuscaHistoricoTabela() {
	$.post("../model/Ticket.php", {
		acao : 'Busca_PagamentoPendente_Tabela',
		
	},function(data) {
		$("#Saldo").html(data['Saldo']);
		tabelaBuscaHistorico.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaHistorico.row.add([data['Html'][i]['Placa'],data['Html'][i]['DataHora'],data['Html'][i]['Status'],data['Html'][i]['Botao']]);
        }
		tabelaBuscaHistorico.draw();
    }, "json");


}
function BuscaTicketInfo(CodTicket) {

    $.post("../model/Ticket.php", {
        acao : 'Renova_Ticket',
        Cod_Id : CodTicket
    }, function(data) {
        ComboBox_TipoVeiculo();
        $('#ConfirmaLiberacao').modal('hide');
        $('#IncluirTicket').modal("show");
        $('#Txt_Placa').val(data['Html']['Placa']);
        DataHoraAtual();
        BotaoTaxa(data['Html']['IdTrans']);
        $('#Txt_TipoVeiculo').val(data['Html']['IdTrans']);
        $('#Txt_LocalFiscal').val(data['Html']['IDLOCALFISCAL']);
       // $('#Txt_Fiscal').html(data['Html'][0]['Fiscal']);
       // BuscaPlaca(data['Html']['Placa']);
        timestamp();
       
    }, "json");

}
//limpa os campos
function limpacampos() {
	$(".TextArea").val("");
	$("input[type=text]").val("");
	$("input[type=time]").val("");
	$("input[type=email]").val("");
	$("input[type=password]").val("");
	$("input[type=number]").val("");
	$("input[type=date]").val("");
	$(":radio").prop({checked: false});
}

//retorna na pagina anterior
function retornarpagina() {
	window.history.go(-1);
}

function LiberarVaga(Cod_Ticket){

	$.post("../model/Ticket.php", {
		acao : 'Libera_Vaga',
        Ticket : Cod_Ticket
	}, function(data) {
		if(data['Cod_Error']==0){
            BuscaTicket();
           // $('.PesquisaPlaca').empty();
		}
	}, "json");

}



function Evasao(Cod_Ticket){

    $.post("../model/Ticket.php", {
        acao : 'Evasao',
        Cod_Ticket : Cod_Ticket
    }, function(data) {
        if(data['Cod_Error']==0){
            alert("Notificado Evasão");
            BuscaHistoricoTabela();
        }
    }, "json");

}
function Pagamento(Cod_Ticket){

    $.post("../model/Ticket.php", {
        acao : 'Pagamento',
        Cod_Ticket : Cod_Ticket
    }, function(data) {
        if(data['Cod_Error']==0){
            alert("Notificação Pago");
            BuscaHistoricoTabela();
        }
    }, "json");

}





//Libera Veiculo do Pre Liberacao
function InfoTicket(codigo) {

    $.post('../model/Ticket.php', {
        acao   : 'Busca_InfoTicket',
        Cod_Id    : codigo
       
    }, function(data) {
		$('#Txt_Ticket').html(data['Html']['Ticket']);
		$('#Txt_Valor').html(data['Html']['Valor']);
		$('#Txt_Placa').html(data['Html']['Placa']);
		$('#Txt_Fiscal').html(data['Html']['Fiscal']);
		$('#Txt_DataHoraSaida').html(data['Html']['DataHoraSaida']);
		$('#Txt_DataHoraEntrada').html(data['Html']['DataHoraEnt']);
		$('#Txt_Localidade').html(data['Html']['Localidade']);
       $("#TicketInfo").modal('show');
    }, "json");

}





