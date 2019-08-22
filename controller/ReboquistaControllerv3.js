/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
tabelaBuscaReboquista=null;
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
    instanciaTabelaBusca();
    BuscaReboquistaTabela();

});

//Botão para Editar Reboque
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaReboquistaFormulario($(this).attr("codigo"));
});

//Botão para Excluir Reboquista
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirReboquista($(this).attr("codigo"));
	}
	BuscaReboquistaTabela();
});
//Botão para  formulario incluir Reboquista
$(document).off("click", "#btnReboquista");
$(document).on("click", "#btnReboquista", function() {
	$('.msg').empty();
	$('#IncluirReboquista').modal('show');
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaReboquista();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraReboquista();
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

    if (tabelaBuscaReboquista != null) {
        tabelaBuscaReboquista.destroy();
        tabelaBuscaReboquista = null;
    } else {
        tabelaBuscaReboquista = $('#TabelaReboquistas').DataTable({
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

function BuscaReboquistaFormulario(cod_reboquista) {

	$.post("../model/Reboquistas.php", {
		acao : 'Busca_Reboquista_Formulario',
		Cod_Reboquista : cod_reboquista
	}, function(data) {

		$('#Txt_Codigo').val(cod_reboquista);
		$('#ATxt_Reboquista').val(data['Html']['Reboquista']);
        $('#ATxt_Telefone').val(data['Html']['Telefone']);
        $('#ATxt_Celular').val(data['Html']['Celular']);
		$('#AlterarReboquista').modal("show");
	}, "json");

}

function BuscaReboquistaTabela() {

	$.post("../model/Reboquistas.php", {
		acao : 'Busca_Reboquista_Tabela',

	},function(data) {
        tabelaBuscaReboquista.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaReboquista.row.add([data['Html'][i]['Reboquista'],data['Html'][i]['Telefone'],data['Html'][i]['Celular'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaReboquista.draw();
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



//função para cadastrar Reboquista
function SalvaReboquista() {

	$('#FrmSalvarReboquista').ajaxForm({
		url : '../model/Reboquistas.php',
		data : {
			acao : 'Salva_Reboquista'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirReboquista').modal('hide');
				BuscaReboquistaTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

//função para Alterar Reboquista
function AlteraReboquista() {

	$('#FrmAlterarReboquista').ajaxForm({
		url : '../model/Reboquistas.php',
		data : {

			acao : 'Alterar_Reboquista'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarReboquista').modal('hide');
				BuscaReboquistaTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirLocalFiscal(Cod_localfiscal){

	$.post("../model/LocalFiscal.php", {
		acao : 'Exclui_localfiscal',
        Cod_LocalFiscal : Cod_localfiscal
	}, function(data) {
		if(data['Cod_error']==0){
			BuscaReboquistaTabela();
		}
	}, "json");

}

