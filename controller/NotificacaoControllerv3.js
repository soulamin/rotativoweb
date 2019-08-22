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
    Combobox_TipoNotificacao() ;
    Combobox_Localidade();

});
//Botão para Pesquisa Placa
$(document).off("click", "#btnPesquisaPlaca");
$(document).on("click", "#btnPesquisaPlaca", function() {
    BuscaTicketPlaca($('#Tipo').val(),$('#Dados').val());
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
    Salva_Notificacao();
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

function BuscaTicketPlaca(tipo,dados){

    $.post("../model/Ticket.php", {
        acao : 'Busca_TicketPlacaFiscal',
        Tipo : tipo,
        Dados : dados 
        
    }, function(data) {
       
            //$('.GerenciaTickets').html();
            $('.PesquisaPlaca').html(data['Html']);
      
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
function Combobox_TipoNotificacao() {

    $.post('../model/Notificacao.php', {
        acao : 'Combobox_TipoNotificacao',

    }, function(data) {
        $('.TipoNoticacao').html(data['Html']);

    }, "json");

}
//busca  cadastrada  para a combobox
function Combobox_Localidade() {

    $.post('../model/Localidade.php', {
        acao : 'Combobox_Localidade'

    }, function(data) {
        $('.Localidade').html(data['Html']);

    }, "json");

}

//função para SalvaTicket
function Salva_Notificacao() {

	$('#FrmSalvarNotificacao').ajaxForm({
		url : '../model/Notificacao.php',
		data : {

			acao : 'Salva_Notificacao'
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

f
//busca as Tipoveiculo combobox
function ComboBox_TipoVeiculo() {

    $.post('../model/TipoVeiculos.php', {
        acao : 'Combobox_TipoVeiculo'
    }, function(data) {
        $('.TipoVeiculo').html(data['Html']);
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

