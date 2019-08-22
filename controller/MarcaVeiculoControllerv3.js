/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaMarcaVeiculo= null;

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
	Combobox_TipoTransp();
	instanciaTabelaBusca();
	BuscaMarcaVeiculoTabela();
});

//Botão para Editar Admin
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	Combobox_TipoTransp();
	BuscaMarcaFormulario($(this).attr("codigo"));
});

//Botão para Excluir Indicador
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {

	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirMarca($(this).attr("codigo"));
			}
	BuscaMarcaVeiculoTabela();
	
});

//Botão para  formulario incluir Marca Veiculo
$(document).off("click", "#btnMarcaVeiculo");
$(document).on("click", "#btnMarcaVeiculo", function() {
	$('.msg').empty();
	Combobox_TipoTransp();
	$('#IncluirMarcaVeiculo').modal('show');
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaMarcaVeiculo();
});


//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraMarca();
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

	if (tabelaBuscaMarcaVeiculo != null) {
		tabelaBuscaMarcaVeiculo.destroy();
		tabelaBuscaMarcaVeiculo = null;
	} else {
		tabelaBuscaMarcaVeiculo = $('#TabelaMarcaVeiculo').DataTable({
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


function Combobox_TipoTransp(){

	$.post("../model/TipoVeiculos.php", {
		acao : 'Combobox_TipoVeiculo',
	}, function(data) {

			$('.TipoTransp').empty();
			$('.TipoTransp').html(data['Html'])

	}, "json");

}
function BuscaMarcaFormulario(cod_marca) {

	$.post("../model/Marcaveiculos.php", {
		acao : 'Busca_Marca_Formulario',
		Cod_Marca : cod_marca
	}, function(data) {

		$('#Txt_Codigo').val(cod_marca);
		$('#ATxt_TipoTransp').append(data['Html']['Tipo']);
		$('#ATxt_Marca').val(data['Html']['Marca']);
		$('#AlterarMarcaVeiculo').modal("show");
	}, "json");

}

function BuscaMarcaVeiculoTabela() {

	$.post("../model/MarcaVeiculos.php", {
		acao : 'Busca_MarcaVeiculo_Tabela',

	}, function(data) {
		$('.ResultadoMarca').empty();
		$('.ResultadoMarca').html(data['Html']);

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

//função para cadastrar Marca Veiculo
function SalvaMarcaVeiculo() {

	$('#FrmSalvarMarcaVeiculo').ajaxForm({
		url : '../model/MarcaVeiculos.php',
		data : {
			acao : 'Salva_MarcaVeiculo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirMarcaVeiculo').modal('hide');
				BuscaMarcaVeiculoTabela();

			}
			$('.msg').html(data['Html']);
		}
	});

}


//função para Alterar Marca
function AlteraMarca() {

	$('#FrmAlterarMarcaVeiculo').ajaxForm({
		url : '../model/MarcaVeiculos.php',
		data : {
			acao : 'Altera_MarcaVeiculo'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarMarcaVeiculo').modal('hide');
				BuscaMarcaVeiculoTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirMarca(Cod_Marca){

	$.post("../model/MarcaVeiculos.php", {
		acao : 'Exclui_MarcaVeiculo',
		Cod_Marca : Cod_Marca
	}, function(data) {
			if(data['Cod_error']==0){
				BuscaMarcaVeiculoTabela();
			}
	}, "json");

}


