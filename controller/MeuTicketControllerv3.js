/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
$(".Placa").inputmask({
	mask : ["AAA9999", "AAA9A99"],
	keepStatic : true
});
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
   
    ComboBox_TipoVeiculo() ;
    BotaoTaxa();
    Combobox_Local();
    timestamp();
    Combobox_Placa();
    Saldo();
});


//Botão para Com Valores
$(document).off("click", ".BotaoTaxas");
$(document).on("click", ".BotaoTaxas", function() {
    SelecionarBotao($(this).attr('codigo'),$(this).attr('valor'));
    CalculaTempo($(this).attr("tempo") ,$('.DataHoraEnt').val());
});


//Botão para  formulario incluir Reboque
$(document).off("click", "#btnReboque");
$(document).on("click", "#btnReboque", function() {
	$('.msg').empty();
	$('#IncluirReboque').modal('show');
});

//Botão alterar taxas no botao
$(document).off("change", ".TipoVeiculo");
$(document).on("change", ".TipoVeiculo", function() {
    BotaoTaxa($(this).val());
    BuscaPlaca($('.Placa').val());
    DataHoraAtual();
});

//Botão para Salvar Cadastro
$(document).off("click", "#btnLimpar");
$(document).on("click", "#btnLimpar", function() {
    window.history.go(0);
});

//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
    Salva_Ticket();
});

//Botão para Evasao Cadastro
$(document).off("click", "#btnEvasao");
$(document).on("click", "#btnEvasao", function() {
   $('#Txt_Evasao').val("1");
    Salva_Ticket();
});


//Botão para Retornar
$(document).off("click", "#btnRetornar");
$(document).on("click", "#btnRetornar", function() {
	retornarpagina();
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

function DataHoraAtual() {
	$.post("../model/Ticket.php", {
		acao : 'DataHoraAtual',
	}, function(data) {
		$('.DataHoraEnt').val(data['DataHoraEnt']);

	}, "json");

}

function Saldo(){

	$.post("../model/Ticket.php", {
		acao : 'Saldo'
        
	}, function(data) {
		$("#Saldo").html(data['Saldo']);				
			
	}, "json");

}

function timestamp() {
    $.post("../model/Ticket.php", {
		acao : 'DataHoraTimeStamp',
	}, function(data) {
		$('.IdTime').val(data['TimeStamp']);
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
    timestamp();
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
function Combobox_Placa() {

    $.post('../model/Usuarios.php', {
        acao : 'Combobox_PlacaUsuario',

    }, function(data) {
        $('.PlacaUsuario').html(data['Html']);
        $('#Saldo').html(data['Saldo']);

    }, "json");

}

//busca  cadastrada  para a combobox
function Combobox_Local() {

    $.post('../model/LocalFiscal.php', {
        acao : 'Combobox_localFiscal',

    }, function(data) {
        $('.Local').html(data['Html']);

    }, "json");

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
            switch (data['Cod_Error']) {
                case "0":
                        window.history.go(0);
                        limpacampos();
                break;
                case "5":
                    alert("PLACA AINDA EM PERIODO VIGENTE");
                break;
                case "10":
                    alert("EVASÃO CADASTRADO COM SUCESSO");
                    window.history.go(0);
                   //  limpacampos();
                break;
                case "3":
                    alert("POR FAVOR PREENCHER TODOS OS DADOS");
                break;
            } 

		}
	});
}

function LiberarVaga(Cod_Ticket){
	$.post("../model/Ticket.php", {
		acao : 'Exclui_Reboque',
        Cod_Reboque : Cod_Reboque
	}, function(data) {
		if(data['Cod_error']==0){
            BuscaReboqueTabela();
            BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val());
		}
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

//VerificaSaldo
function VerificaSaldo(valor) {

    $.post('../model/Ticket.php', {
        acao : 'VerificaSaldo',
        Valor : valor
    }, function(data) {
        if(data['Cod_Error']){
            $('#btnSalvar').attr('hidden',true);
            alert("SALDO INSUFICIENTE");
        }else{
            $('#btnSalvar').attr('hidden',false);
        }
      
    }, "json");

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
    $('.BotaoTaxas').removeClass("bg-warning");
     $('#'+codigo).addClass("bg-warning");
     $('#Taxas').val(codigo);
     $('#Valor').val(valor);
     VerificaSaldo(valor);
}