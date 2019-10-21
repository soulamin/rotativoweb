/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/

var tabelaBuscaReboque = null;

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
    BuscaTicket();
    BuscaTicketNotificado();
 
});


//Botão para  Liberar Vaga
$(document).off("click", ".btnLiberarVaga");
$(document).on("click", ".btnLiberarVaga", function() {
   $('#ConfirmaLiberacao').modal('show');
  $('#btnRenovaTicket').attr("codigo",$(this).attr('codigo'));
   LiberarVaga($(this).attr('codigo'));
});

//Botão para  Modal Alterar Local
$(document).off("click", ".btnAlterarLocal");
$(document).on("click", ".btnAlterarLocal", function() {
   $('#AlteraLocal').modal('show');
  $('#ATxt_IdTicket').val($(this).attr('codigo'));
  Combobox_Local();

});


//Botão para  Alterar Localidade
$(document).off("click", ".AlterarLocalidade");
$(document).on("click", ".AlterarLocalidade", function() {
    Altera_Local();
   
});


//Botão para  Liberar Vaga
$(document).off("click", "#btnRenovaTicket");
$(document).on("click", "#btnRenovaTicket", function() {
    BuscaTicketInfo($(this).attr('codigo'));
   
});


//Botão para Com Valores
$(document).off("click", ".BotaoTaxas");
$(document).on("click", ".BotaoTaxas", function() {
    SelecionarBotao($(this).attr('codigo'),$(this).attr('valor'));
    CalculaTempo($(this).attr("tempo") ,$('.DataHoraEnt').val());
});

//Botão para  Libearar Vaga
$(document).off("click", ".btnReimprimir");
$(document).on("click", ".btnReimprimir", function() {
    Reimprimir($(this).attr('codigo'));
});


//Botão para  Pagamento
$(document).off("click", ".btnPagar");
$(document).on("click", ".btnPagar", function() {
    Pagamento($(this).attr('codigo'));
});

//Botão para  Evasao
$(document).off("click", ".btnEvasao");
$(document).on("click", ".btnEvasao", function() {
    Evasao($(this).attr('codigo'));
});


//Botão para  Evasao
$(document).off("click", ".btnPagarEvasao");
$(document).on("click", ".btnPagarEvasao", function() {
    VerValorPg($(this).attr('codigo'));
});

//Botão para  Evasao
$(document).off("click", ".PagarFracao");
$(document).on("click", ".PagarFracao", function() {
    PagamentoFracao($('#IdTicket').val(),$('#Valor').val(),$('#HoraSaida').val());
});

//Botão para  Pagamento
$(document).off("click", ".btnPagar");
$(document).on("click", ".btnPagar", function() {
    AbreModalPgNot($(this).attr('codigo'));
});

//Botão para Pesquisa Placa
$(document).off("click", "#btnPesquisaPlaca");
$(document).on("click", "#btnPesquisaPlaca", function() {
    BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val(),$('#DataEnt').val());
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
    Salva_Ticket();
});


//Botão para Retornar
$(document).off("click", "#btnRetornar");
$(document).on("click", "#btnRetornar", function() {
	retornarpagina();
});


//busca  cadastrada  para a combobox
function Combobox_Local() {
    $.post('../model/LocalFiscal.php', {
        acao : 'Combobox_localFiscal',
    }, function(data) {
        $('.Local').html(data['Html']);
    }, "json");
}

//Botão para  Pagamento
$(document).off("click", ".btnPagar");
$(document).on("click", ".btnPagar", function() {
    AbreModalPgNot($(this).attr('codigo'));
    // Pagamento($(this).attr('codigo'));
    // $('#ModalPgNot').modal('show');
});
/*=======================================================================================
 *
 *
 * FUNCTIONS
 *
 *
 =======================================================================================*/
function instanciaTabelaBusca() {

    if (tabelaBuscaReboque != null) {
        tabelaBuscaReboque.destroy();
        tabelaBuscaReboque = null;
    } else {
        tabelaBuscaReboque = $('#TabelaReboques').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
            },
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



//função para SalvaTicket
function Salva_Ticket() {

	$('#FrmSalvarTicket').ajaxForm({
		url : '../model/Ticket.php',
		data : {
			acao : 'Salva_Ticket'
		},
		dataType : 'json',
		success : function(data) {

			if (data['Cod_Error'] == 0) {
                if (Android) {
                        Android.showToast(JSON.stringify(data['Msg']));
                        Android.sendbeep("1");
                }
                window.location.reload();
				limpacampos();

            }else if(data['Cod_Error'] == 5) {
                alert("PLACA JÁ CADASTRADA!");
            }else{

                alert("POR FAVOR PREENCHER TODOS OS DADOS");

            }

		}
	});

}


//função para Salvar Localidade
function Altera_Local() {

	$('#FrmAlterarLocal').ajaxForm({
		url : '../model/Ticket.php',
		data : {
			acao : 'Altera_Localidade'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
                $('#AlteraLocal').modal('hide');
            }
		}
	});

}

function RetornaDataHoraAtual(){
    var dNow = new Date();
    var localdate =  dNow.getDate()  + '/' + (dNow.getMonth()+1) + '/' + dNow.getFullYear()  ;
    $('#DataEnt').val(localdate);
  }

function timestamp() {
    $.post("../model/Ticket.php", {
		acao : 'DataHoraTimeStamp',
	}, function(data) {
		$('.IdTime').val(data['TimeStamp']);
	}, "json");
}


function BuscaTicketInfo(CodTicket) {

    $.post("../model/Ticket.php", {
        acao : 'Renova_Ticket',
        Cod_Id : CodTicket
    }, function(data) {
        timestamp();
        ComboBox_TipoVeiculo();
        $('#ConfirmaLiberacao').modal('hide');
        $('#IncluirTicket').modal("show");
        $('#Txt_Placa').val(data['Html']['Placa']);
        DataHoraAtual();
        BotaoTaxa(data['Html']['IdTrans']);
        $('#Txt_TipoVeiculo').val(data['Html']['IdTrans']);
        $('#Txt_LocalFiscal').val(data['Html']['IDLOCALFISCAL']);
       // $('#Txt_Fiscal').html(data['Html'][0]['Fiscal']);
       // BuscaPlaca(data['Html'][0]['Placa']);
        
       
    }, "json");

}

function DataHoraAtual() {
	$.post("../model/Ticket.php", {
		acao : 'DataHoraAtual',
	}, function(data) {
		$('.DataHoraEnt').val(data['DataHoraEnt']);

	}, "json");

}

function BotaoTaxa(idtransp) {

    $.post("../model/Taxa.php", {
        acao : 'BotaoTaxa',
        IdTransp : idtransp
    }, function(data) {
       $('.Taxas').html(data['Html']);
    }, "json");

}

//limpa os campos
function limpacampos() {
	$(".TextArea").val("");
	$(":text").val("");
	$(":password").val("");
	$(".Valor").val("1");
	$(".ordem").val("1");
}

//retorna na pagina anterior
function retornarpagina() {
	window.history.go(-1);
}

//busca  cadastrada  para a combobox
function Combobox_FormaPg() {

    $.post('../model/FormaPg.php', {
        acao : 'Combobox_FormaPg',

    }, function(data) {
        $('.FormaPg').html(data['Html']);

    }, "json");

}

//busca  cadastrada  para a combobox
function BuscaTicket() {
    $.post('../model/Ticket.php', {
        acao : 'Busca_Ticket',
    }, function(data) {
        $('.GerenciaTickets').html(data['Html']);
    }, "json");

}

//função para SalvaTicket
function Salva_Ticket() {

	$('#FrmSalvarTicket').ajaxForm({
		url : '../model/Ticket.php',
		data : {

			acao : 'SalvaRenovaTicket'
		},
		dataType : 'json',
		success : function(data) {

			if (data['Cod_Error'] == 0) {
                if (Android) {
                        Android.showToast(JSON.stringify(data['Msg']));
                        Android.sendbeep("1");
                }
                window.location.reload();
				limpacampos();
                $('#IncluirTicket').modal('hide');
            }else if(data['Cod_Error'] == 5) {
                alert("PLACA AINDA EM  PERÍODO VIGENTE!");
            }else{

                alert("POR FAVOR PREENCHER TODOS OS DADOS");

            }

		}
	});

}

function LiberarVaga(Cod_Ticket){

	$.post("../model/Ticket.php", {
		acao : 'Libera_Vaga',
        Ticket : Cod_Ticket
	}, function(data) {
		if(data['Cod_Error']==0){
            BuscaTicket();
            BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val());
		}
	}, "json");

}

function Reimprimir(Cod_Ticket){

    $.post("../model/Ticket.php", {
        acao : 'Reimprimir_Ticket',
        Cod_Ticket : Cod_Ticket
    }, function(data) {
        if(data['Cod_Error']==0){
            if (Android) {
                Android.showToast(JSON.stringify(data['Msg']));
            }
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
            BuscaTicketNotificado();
            BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val(),$('#DataEnt').val());
            if (Android) {
                Android.showToast(JSON.stringify(data['Msg']));
            }
        }
    }, "json");

}
function Pagamento(Cod_Ticket){

    $.post("../model/Ticket.php", {
        acao : 'Pagamento',
        Cod_Ticket : Cod_Ticket
    }, function(data) {
        if(data['Cod_Error']==0){
            BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val(),$('#DataEnt').val());
            alert("Notificação Pago");
            BuscaTicketNotificado();
            if (Android) {
                Android.showToast(JSON.stringify(data['Msg']));
            }
        }
    }, "json");

}


function VerValorPg(Cod_Ticket){

    $.post("../model/Ticket.php", {
        acao : 'PagamentoEvasao',
        Cod_Ticket : Cod_Ticket
    }, function(data) {
        if(data['Cod_Error']==0){
            BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val(),$('#DataEnt').val());
            alert("Notificação Pago");
            BuscaTicketNotificado();
        }
    }, "json");

}



function BuscaTicketPlaca(tipo,dados,dataent){

    $.post("../model/Ticket.php", {
        acao : 'Busca_TicketPlaca',
        Tipo : tipo,
        Dados : dados ,
        DataEnt : dataent 
    }, function(data) {
       
            //$('.GerenciaTickets').html();
            $('.PesquisaPlaca').html(data['Html']);
      
    }, "json");

}

function BuscaTicketNotificado(){

    $.post("../model/Ticket.php", {
        acao : 'Busca_TicketNotificado'
       
    }, function(data) {
       
            $('.TicketsNotificados').html(data['Html']);
      
    }, "json");

}
//busca as Tipoveiculo combobox
function ComboBox_TipoVeiculo() {

    $.post('../model/TipoVeiculos.php', {
        acao : 'Combobox_TipoVeiculo'
    }, function(data) {
        $('.TipoVeiculo').html(data['Html']);
    }, "json");

}

function CalculaTempo(tempo ,dataticket){

    $.post("../model/Ticket.php", {
        acao : 'CalculaTempo',
        Tempo   : tempo,
        DataHoraEnt : dataticket
    }, function(data) {
        $('.DataHoraSaida').val(data['DataHoraSaida']);
        //$('.HoraSaida').val(data['HoraSaida']);

    }, "json");

}

function SelecionarBotao(codigo,valor){
    $('.BotaoTaxas').removeClass("bg-primary");
     $('#'+codigo).addClass("bg-primary");
     $('#Taxas').val(codigo);
     $('#Valor').val(valor);
}

function BuscaPlaca(placa) {
    $.get('../model/ApiVeiculo.php', {
        placa : placa
    }, function(data) {
        if(data.codigoRetorno==0){
            if(data.codigoSituacao==1){
                alert("ATENÇÃO VEÍCULO \n" + data.situacao);
            }
            $(".Cor").val(data.cor);
            $(".MarcaModelo").val(data.modelo);


        }else{
            $(".Cor").val("");
            $(".MarcaModelo").val("");

        }


    }, "json");

}

//busca Pagamento de fracao
function AbreModalPgNot(codticket) {
    $.post('../model/Ticket.php', {
        acao       : 'CalculaFracaoPendente',
        Cod_Ticket : codticket
    }, function(data) {
        $('#ModalPgNot').modal('show');
        $('#Valor').val(data['Valor']);
        $('#IdTicket').val(data['IdTicket']);
        $('#HoraEnt').val(data['HoraEnt']);
        $('#HoraSaida').val(data['HoraSaida']);
        $('#Tempo').val(data['Tempo']);
        // $('.GerenciaTickets').html(data['Html']);
    }, "json");

}

function PagamentoFracao(IdTicket,Valor,HoraSaida){

    $.post("../model/Ticket.php", {
        acao : 'PagamentoFracao',
        IdTicket : IdTicket,
        Valor : Valor ,
        HoraSaida : HoraSaida
    }, function(data) {
        if(data['Cod_Error']==0){
            Reimprimir(IdTicket);
            BuscaTicketNotificado();
            $('#ModalPgNot').modal('hide');
            BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val(),$('#DataEnt').val());
        }
    }, "json");

}