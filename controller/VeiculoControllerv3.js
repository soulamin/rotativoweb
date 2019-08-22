/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/


$(".Celular").inputmask({
	mask : ["(99)9999-9999", "(99)99999-9999"],
	keepStatic : true
});
$(".PLACA").inputmask("AAA-9999");
$(".ANO").inputmask("9999");
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

	BuscaVeiculoTabela();
	Combobox_TipoVeiculo();
	Combobox_MarcaTransp(0);
	Combobox_ModeloTransp(0);
	Combobox_Ponto();
	Combobox_CorTransp();
	Combobox_Equipamento();

});

//Botão para Editar Veiculo
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaVeiculoFormulario($(this).attr("codigo"));
});

//Botão para Excluir Indicador
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {

	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirVeiculo($(this).attr("codigo"));
			}
	BuscaVeiculoTabela();
	
});

//Botão para  formulario incluir Veiculo
$(document).off("click", "#btnVeiculo");
$(document).on("click", "#btnVeiculo", function() {
	$('.msg').empty();
	Combobox_TipoVeiculo();
	Combobox_MarcaTransp(0);
	Combobox_ModeloTransp(0);
	Combobox_Ponto();
	Combobox_CorTransp();
	Combobox_Equipamento();
	$('#IncluirVeiculo').modal('show');
});

//Ao mudar na combo Buscar Marca
$(document).off("change", ".TipoVeiculo");
$(document).on("change", ".TipoVeiculo", function() {
	Combobox_MarcaTransp($(this).val());
	Combobox_ModeloTransp($(this).val());

});

//Ao mudar na combo Buscar Modelo
$(document).off("change", ".MarcaTransp");
$(document).on("change", ".MarcaTransp", function() {
	Combobox_ModeloTransp($(this).val());
});

//Botão para Buscar ENDEREÇO CEP
$(document).off("blur", ".CEP");
$(document).on("blur", ".CEP", function() {
	BuscaEndereco($(this).val().replace('-',''));

});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaVeiculo();
});


//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraIndicador();
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


//busca a Ponto combobox
function Combobox_Ponto(){

	$.post("../model/Pontos.php", {
		acao : 'Combobox_Ponto',
	}, function(data) {

		$('.Ponto').empty();
		$('.Ponto').html(data['Html'])

	}, "json");

}

//busca Tipo Veiculo combobox
function Combobox_TipoVeiculo(){

	$.post("../model/TipoVeiculos.php", {
		acao : 'Combobox_TipoVeiculo',
	}, function(data) {
		$('.TipoVeiculo').empty();
		$('.TipoVeiculo').html(data['Html'])

	}, "json");

}

//busca a cor do veiculo combobox
function Combobox_CorTransp(){

	$.post("../model/CorVeiculos.php", {
		acao : 'Busca_CorVeiculoCombobox',
	}, function(data) {

		$('.Cor').empty();
		$('.Cor').html(data['Html'])

	}, "json");
}

function Combobox_MarcaTransp(Cod_TipoTransp){

	$.post("../model/MarcaVeiculos.php", {
		acao : 'Busca_MarcaVeiculoCombobox',
		Cod_TipoTransp : Cod_TipoTransp
	}, function(data) {

		$('.MarcaTransp').empty();
		$('.MarcaTransp').html(data['Html'])

	}, "json");

}

function Combobox_ModeloTransp(Cod_MarcaTransp){

	$.post("../model/ModeloVeiculos.php", {
		acao : 'Combobox_ModeloVeiculo',
		Cod_MarcaTransp : Cod_MarcaTransp
	}, function(data) {

		$('.ModeloTransp').empty();
		$('.ModeloTransp').html(data['Html'])

	}, "json");

}

//busca Veiculos
function Combobox_Veiculos(Ponto){

	$.post("../model/Motoristas.php", {
		acao : 'Combobox_Veiculo_Motorista',
		Cod_Ponto : Ponto
	}, function(data) {
		$('.Veiculos').empty();
		$('.Veiculos').html(data['Html'])

	}, "json");

}

function Combobox_Equipamento(){

	$.post("../model/Equipamentos.php", {
		acao : 'Combobox_Equipamento',

	}, function(data) {

		$('.Equipamento').empty();
		$('.Equipamento').html(data['Html'])

	}, "json");

}

function BuscaVeiculoFormulario(Cod_Veiculo) {

	$.post("../model/Veiculos.php", {
		acao : 'Busca_Veiculo_Formulario',
		Cod_Veiculo : Cod_Veiculo
	}, function(data) {

		$('#ATxt_Codigo').val(Cod_Veiculo);
		$('#ATxt_Ponto').prepend(data['Html']['Ponto']);
		$('#ATxt_Placa').val(data['Html']['Placa']);
		$('#ATxt_Cor').prepend(data['Html']['Cor']);
		$('#ATxt_Chassi').val(data['Html']['Chassi']);
		$('#ATxt_Ano').val(data['Html']['Ano']);
		$('#ATxt_Renavan').val(data['Html']['Renavan']);
		$('#ATxt_Tipo').prepend(data['Html']['Tipo']);
		$('#ATxt_Marca').prepend(data['Html']['Marca']);
		$('#ATxt_Modelo').prepend(data['Html']['Modelo']);
		$('#ATxt_Equipamento').prepend(data['Html']['Equipamento']);

		$('#AlterarVeiculo').modal("show");
	}, "json");

}

function BuscaVeiculoTabela() {

	$.post("../model/Veiculos.php", {
		acao : 'Busca_Veiculos_Tabela',

	}, function(data) {
		$('.ResultadoVeiculo').empty();
		$('.ResultadoVeiculo').html(data['Html']);

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

//função para cadastrar Veiculos
function SalvaVeiculo() {

	$('#FrmSalvarVeiculo').ajaxForm({
		url : '../model/Veiculos.php',
		data : {
			acao : 'Salva_Veiculo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirVeiculo').modal('hide');
				BuscaVeiculoTabela();

			}
			$('.msg').html(data['Html']);
		}
	});

}


//função para Alterar Indicador
function AlteraIndicador() {

	$('#FrmAlterarInd').ajaxForm({
		url : '../model/indicadores.php',
		data : {
			acao : 'Altera_Indicador'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarInd').modal('hide');
				BuscaIndTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirVeiculo(Cod_Veiculo){

	$.post("../model/Veiculos.php", {
		acao : 'Exclui_Veiculo',
		Cod_Veiculo : Cod_Veiculo
	}, function(data) {
			if(data['Cod_error']==0){
				BuscaVeiculoTabela();
			}
	}, "json");



}


