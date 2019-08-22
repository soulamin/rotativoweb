/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/


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
    BuscaTipoPagamentoTabela();

});

//Botão para Editar Cor
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaTipoPagamentoFormulario($(this).attr("codigo"));
});

//Botão para Excluir Cor
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirTipoPagamento($(this).attr("codigo"));
	}
	BuscaTipoPagamentoTabela();
});
//Botão para  formulario incluir Cor
$(document).off("click", "#btnTipoPagamento");
$(document).on("click", "#btnTipoPagamento", function() {
	$('.msg').empty();
	$('#IncluirTipoPagamento').modal('show');
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaTipoPagamento();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraTipoPagamento();
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


function BuscaTipoPagamentoFormulario(cod_TipoPagamento) {

	$.post("../model/TipoPagamento.php", {
		acao : 'Busca_TipoPagamento_Formulario',
		Cod_TipoPagamento : cod_TipoPagamento
	}, function(data) {

		$('#Txt_Codigo').val(cod_TipoPagamento);
		$('#ATxt_TipoPagamento').val(data['Html']['TipoPagamento']);
		$('#AlterarTipoPagamento').modal("show");
	}, "json");

}

function BuscaTipoPagamentoTabela() {

	$.post("../model/TipoPagamento.php", {
		acao : 'Busca_TipoPagamento_Tabela',

	}, function(data) {
		$('.ResultadoTipoPagamento').empty();
		$('.ResultadoTipoPagamento').html(data['Html']);

	}, "json");

}

//limpa os campos
function limpacampos() {
	$(".TextArea").val("");
	$("input[type=text]").val("");
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



//função para cadastrar Cor
function SalvaTipoPagamento() {

	$('#FrmSalvarTipoPagamento').ajaxForm({
		url : '../model/TipoPagamento.php',
		data : {
			acao : 'Salva_TipoPagamento'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirTipoPagamento').modal('hide');
				BuscaTipoPagamentoTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

//função para Alterar Cor
function AlteraTipoPagamento() {

	$('#FrmAlterarTipoPagamento').ajaxForm({
		url : '../model/TipoPagamento.php',
		data : {

			acao : 'Alterar_TipoPagamento'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarTipoPagamento').modal('hide');
				BuscaTipoPagamentoTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirTipoPagamento(Cod_Pagamento){

	$.post("../model/TipoPagamento.php", {
		acao : 'Exclui_TipoPagamento',
		Cod_TipoPagamento : Cod_Pagamento
	}, function(data) {
		if(data['Cod_error']==0){
			BuscaTipoPagamentoTabela();
		}
	}, "json");

}

