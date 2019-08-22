/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaAgente = null;

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
    BuscaAgenteFiscalizadorTabela();

});

//Botão para Editar Cor
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaAgenteFiscalizadorFormulario($(this).attr("codigo"));
});

//Botão para Excluir Cor
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirAgenteFiscalizador($(this).attr("codigo"));
	}
	BuscaAgenteFiscalizadorTabela();
});

//Botão para  formulario incluir Cor
$(document).off("click", "#btnAgenteFiscalizador");
$(document).on("click", "#btnAgenteFiscalizador", function() {
	$('.msg').empty();
	$('#IncluirAgenteFiscalizador').modal('show');
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaAgenteFiscalizador();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraAgenteFiscalizador();
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

    if (tabelaBuscaAgente != null) {
        tabelaBuscaAgente.destroy();
        tabelaBuscaAgente = null;
    } else {
        tabelaBuscaAgente = $('#TabelaAgentes').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5'
			],
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
function BuscaAgenteFiscalizadorFormulario(cod_agentefiscalizador) {

	$.post("../model/LocalFiscal.php", {
		acao : 'Busca_AgenteFiscalizador_Formulario',
		Cod_AgenteFiscalizador : cod_agentefiscalizador
	}, function(data) {

		$('#Txt_Codigo').val(cod_agentefiscalizador);
		$('#ATxt_Nome').val(data['Html']['Nome']);
		$('#AlterarAgenteFiscalizador').modal("show");
	}, "json");

}

function BuscaAgenteFiscalizadorTabela() {

	$.post("../model/LocalFiscal.php", {
		acao : 'Busca_AgenteFiscalizador_Tabela',

	},function(data) {
        tabelaBuscaAgente.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaAgente.row.add([data['Html'][i]['Fiscalizador1111'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaAgente.draw();
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


//função para cadastrar AgenteFiscalizador
function SalvaAgenteFiscalizador() {

	$('#FrmSalvarAgenteFiscalizador').ajaxForm({
		url : '../model/LocalFiscal.php',
		data : {
			acao : 'Salva_AgenteFiscalizador'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirAgenteFiscalizador').modal('hide');
				BuscaAgenteFiscalizadorTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

//função para Alterar AgenteFiscalizador
function AlteraAgenteFiscalizador() {

	$('#FrmAlterarAgenteFiscalizador').ajaxForm({
		url : '../model/LocalFiscal.php',
		data : {
			acao : 'Alterar_AgenteFiscalizador'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarAgenteFiscalizador').modal('hide');
				BuscaAgenteFiscalizadorTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirAgenteFiscalizador(Cod_AgenteFiscalizador){

	$.post("../model/LocalFiscal.php", {
		acao : 'Exclui_AgenteFiscalizador',
		Cod_AgenteFiscalizador : Cod_AgenteFiscalizador
	}, function(data) {
		if(data['Cod_error']==0){
			BuscaAgenteFiscalizadorTabela();
		}
	}, "json");

}

