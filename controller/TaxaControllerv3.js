/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaTaxa= null;
$(".Dinheiro").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
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
	BuscaTaxaTabela();
});

//Botão para Editar Taxa
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaTaxaFormulario($(this).attr("codigo"));
});

//Botão para Excluir Infracao
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {

	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirTaxa($(this).attr("codigo"));
			}
	BuscaTaxaTabela();
	
});

//Botão para  formulario incluir Taxa
$(document).off("click", "#btnTaxa");
$(document).on("click", "#btnTaxa", function() {
	$('.msg').empty();
	$('#IncluirTaxas').modal('show');
   ComboboxTipoArea();
    ComboBox_TipoVeiculo();
});

//Botão Km
$(document).off("change", ".kmrebocado");
$(document).on("change", ".kmrebocado", function() {
    if($(this).val()==0){
		$('.VALORKM').prop('hidden',true);
	}else{
        $('.VALORKM').prop('hidden',false);
	}
});

//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaTaxa();
});

//Botão para Excluir
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
    ExcluirTaxa($(this).attr('codigo'));
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
    AlteraTaxa();
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

	if (tabelaBuscaTaxa != null) {
        tabelaBuscaTaxa.destroy();
        tabelaBuscaTaxa = null;
	} else {
        tabelaBuscaTaxa = $('#TabelaTaxas').DataTable({
			"language": {
			"url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
		},
			"responsive": true,
			"paging" : true,
			"lengthChange" : true,
			"searching" : true,
			"ordering" : true,
			"info" : true,
			"autoWidth" : false
		});
	}
}


//busca as infracao cadastrada  para a combobox
function ComboboxTipoArea() {

	$.post('../model/TipoArea.php', {
		acao : 'Combobox_TipoArea'
	}, function(data) {
		//$('.TipoVeiculo').select2();
		$('.TipoArea').html(data['Html']);

	}, "json");

}


function BuscaTaxaFormulario(CodTaxa) {

	$.post("../model/Taxa.php", {
		acao : 'Busca_Taxa_Formulario',
		Cod_Id : CodTaxa
	}, function(data) {
		$('#Txt_Codigo').val(CodTaxa);
        $('#ATxt_QtdHora').val(data['Html']['QtdHora']);
		$('#ATxt_Valor').val(data['Html']['Valor']);
		var TipoVeiculo = data['Html']['TipoVeiculo'];
		ComboBox_TipoVeiculo();
		ComboboxTipoArea();
		var TipoArea= data['Html']['TipoArea'];
	   $('#ATxt_TipoVeiculo').val(TipoVeiculo);
	   $('#ATxt_Area').val(TipoArea);
	   $('#AlterarTaxas').modal();
		
	}, "json");

}

function BuscaTaxaTabela() {

	$.post("../model/Taxa.php", {
		acao : 'Busca_Taxa_Tabela',

	}, function(data) {
        tabelaBuscaTaxa.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaTaxa.row.add([data['Html'][i]['Area'],data['Html'][i]['TipoTransporte'],data['Html'][i]['Valor'],data['Html'][i]['QtdHora'],
				data['Html'][i]['Status'], data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaTaxa.draw();
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

//função para cadastrar Taxa
function SalvaTaxa() {

	$('#FrmSalvarTaxas').ajaxForm({
		url : '../model/Taxa.php',
		data : {
			acao : 'Salva_Taxa'

		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirTaxas').modal('hide');
				BuscaTaxaTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}


//função para Alterar Taxa
function AlteraTaxa() {

	$('#FrmAlterarTaxa').ajaxForm({
		url : '../model/Taxa.php',
		data : {
			acao : 'Altera_Taxa'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarTaxas').modal('hide');
				BuscaTaxaTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirTaxa(Cod_Taxa){

	$.post("../model/Taxa.php", {
		acao : 'Exclui_Taxa',
        Cod_Taxa : Cod_Taxa
	}, function(data) {
			if(data['Cod_error']==0){
				BuscaTaxaTabela();
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