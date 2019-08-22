/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
$(".Dinheiro").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
var tabelaBuscaDesconto = null;

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
    BuscaDescontoTabela();

});

//Botão para Editar Reboque
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaPagamentoFormulario($(this).attr("codigo"));
});

//Botão para Excluir Reboque
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirReboque($(this).attr("codigo"));
	}
	BuscaReboqueTabela();
});
//Botão para  formulario incluir Reboque
$(document).off("click", "#btnReboque");
$(document).on("click", "#btnReboque", function() {
	$('.msg').empty();
	$('#IncluirReboque').modal('show');
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaReboque();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraReboque();
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

    if (tabelaBuscaDesconto != null) {
        tabelaBuscaDesconto.destroy();
        tabelaBuscaDesconto = null;
    } else {
        tabelaBuscaDesconto = $('#TabelaDescontos').DataTable({
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

function BuscaPagamentoFormulario(cod_pagamento) {

	$.post("../model/Pagamentos.php", {
		acao : 'Busca_Pagamento_Formulario',
		Cod_Pagamento : cod_pagamento
	}, function(data) {

		$('#Txt_Codigo').val(cod_pagamento);
        $('#ATipoPg').val(data['Html']['TipoPg']).attr('selected',true);
		$('#ATxt_ValorTotal').val(data['Html']['ValorTotal']);
		$('#AlterarPagamento').modal("show");
	}, "json");

}

function BuscaDescontoTabela() {

    $.post("../model/Desconto.php", {
        acao : 'Busca_Desconto_Tabela',
    }, function(data) {
        tabelaBuscaDesconto.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaDesconto.row.add([data['Html'][i]['Placa'],data['Html'][i]['Grv'],data['Html'][i]['ValorTotal'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaDesconto.draw();
    }, "json");


}



//limpa os campos
function limpacampos() {
    $(".TextArea").val("");
    $(":text").val("");
    $(":password").val("");

}

//retorna na pagina anterior
function retornarpagina() {
	window.history.go(-1);
}



//função para cadastrar Reboque
function SalvaReboque() {

	$('#FrmSalvarReboque').ajaxForm({
		url : '../model/TipoArea.php',
		data : {
			acao : 'Salva_Reboque'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirReboque').modal('hide');
				BuscaReboqueTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

//função para Alterar Reboque
function AlteraReboque() {

	$('#FrmAlterarPagamento').ajaxForm({
		url : '../model/Pagamentos.php',
		data : {

			acao : 'Alterar_Pagamento'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarPagamento').modal('hide');
				BuscaPagamentoTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirReboque(Cod_Reboque){
	$.post("../model/TipoArea.php", {
		acao : 'Exclui_Reboque',
        Cod_Reboque : Cod_Reboque
	}, function(data) {
		if(data['Cod_error']==0){
			BuscaReboqueTabela();
		}
	}, "json");

}

