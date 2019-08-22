/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaTipoVeiculo = null;

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
    instanciaTabelaBusca()
    BuscaTipoVeiculoTabela();

});

//Botão para Editar Cor
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaTipoVeiculoFormulario($(this).attr("codigo"));
});

//Botão para Excluir Cor
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirTipoVeiculo($(this).attr("codigo"));
	}
	BuscaTipoVeiculoTabela();
});

//Botão para  formulario incluir Veiculo
$(document).off("click", "#btnTipoVeiculo");
$(document).on("click", "#btnTipoVeiculo", function() {
	$('.msg').empty();
	$('#IncluirTipoVeiculo').modal('show');
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaTipoVeiculo();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraTipoVeiculo();
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

    if (tabelaBuscaTipoVeiculo != null) {
		tabelaBuscaTipoVeiculo.destroy();
		tabelaBuscaTipoVeiculo = null;
    } else {
		tabelaBuscaTipoVeiculo = $('#TabelaTipoVeiculo').DataTable({
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
function BuscaTipoVeiculoFormulario(cod_TipoVeiculo) {

	$.post("../model/TipoVeiculos.php", {
		acao : 'Busca_TipoVeiculo_Formulario',
		Cod_Tipo : cod_TipoVeiculo
	}, function(data) {

		$('#Txt_Codigo').val(cod_TipoVeiculo);
		$('#ATxt_TipoVeiculo').val(data['Html']['MeioTransporte']);
		$('#AlterarTipoVeiculo').modal("show");
	}, "json");

}

function BuscaTipoVeiculoTabela() {

	$.post("../model/TipoVeiculos.php", {
		acao : 'Busca_TipoVeiculo_Tabela',

	},function(data) {
		tabelaBuscaTipoVeiculo.clear();
        for (var i = 0; i < data['Html'].length; i++) {
			tabelaBuscaTipoVeiculo.row.add([data['Html'][i]['TipoVeiculo'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
		tabelaBuscaTipoVeiculo.draw();
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
	$("input[type=time]").val("");
	$(":radio").prop({checked: false});
}

//retorna na pagina anterior
function retornarpagina() {
	window.history.go(-1);
}


//função para cadastrar Tipo Veiculo
function SalvaTipoVeiculo() {

	$('#FrmSalvarTipoVeiculo').ajaxForm({
		url : '../model/TipoVeiculos.php',
		data : {
			acao : 'Salva_TipoVeiculo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirTipoVeiculo').modal('hide');
				BuscaTipoVeiculoTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

//função para Alterar Tipo Veiculo
function AlteraTipoVeiculo() {

	$('#FrmAlterarTipoVeiculo').ajaxForm({
		url : '../model/TipoVeiculos.php',
		data : {
			acao : 'Alterar_TipoVeiculo'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarTipoVeiculo').modal('hide');
				BuscaTipoVeiculoTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirTipoVeiculo(Cod_TipoVeiculo){

	$.post("../model/TipoVeiculos.php", {
		acao : 'Exclui_TipoVeiculo',
		Cod_TipoVeiculo : Cod_TipoVeiculo
	}, function(data) {
		if(data['Cod_error']==0){
			BuscaTipoVeiculoTabela();
		}
	}, "json");

}

