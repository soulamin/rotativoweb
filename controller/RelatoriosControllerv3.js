/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
$(".PLACA").inputmask("AAA-9999");
var tabelaBuscaRelatorios = null;
var tabelaBuscaAgentes = null;
var data = new Date();
var dia     = data.getDate();           // 1-31
var mes     = data.getMonth();          // 0-11 (zero=janeiro)
var ano     =  data.getFullYear();       // 4 dígitos
var DataHj = ano +'-'+(mes+1)+'-'+ dia ;


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

  

});

//Botão para Editar Reboque
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	BuscaReboqueFormulario($(this).attr("codigo"));
});

//Botão para Estoque Atual
$(document).off("click", "#btnEstoqueAtual");
$(document).on("click", "#btnEstoqueAtual", function() {
$(this).attr('href',"../Relatorios/EstoqueAtual/index.php");
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



//Botão para Busca Tabela
$(document).off("click", "#btnPesquisar");
$(document).on("click", "#btnPesquisar", function() {
	BuscaRelatoriosTabela();
	BuscaRelatoriosTabelaAgentes();
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

    if (tabelaBuscaRelatorios != null) {
		tabelaBuscaRelatorios.destroy();
		tabelaBuscaRelatorios = null;
    } else {
		tabelaBuscaRelatorios = $('#TabelaRelatorios').DataTable({
			dom: 'Bfrtip',
			"buttons" : [
				{
					text: 'Exportar PDF',
					extend: 'pdfHtml5',
					filename: 'VeiculosRecolhidos',
					orientation: 'landscape', //portrait or landscape
					pageSize: 'A4', //A3 , A5 , A6 , legal , letter
					className :'btn bg-navy',
					exportOptions: {
							columns: ':visible',
							search: 'applied',
							order: 'applied'
				}
			},
				{
					text: 'Exportar Excel',
					className :'btn bg-navy',
					extend: 'excelHtml5'
				}
			],

            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json",
				"decimal": ",",
				"thousands": ".",
            },
            "responsive": true,
            "paging" : true,
            "lengthChange" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "autoWidth" : true,
            "processing": true
        });
    }

		$('.buttons-html5').addClass('btn-primary');


}


function instanciaTabelaBuscaAgentes() {

	if (tabelaBuscaAgentes != null) {
		tabelaBuscaAgentes.destroy();
		tabelaBuscaAgentes = null;
	} else {
		tabelaBuscaAgentes = $('#TabelaRelatoriosAgentes').DataTable({
			dom: 'Bfrtip',
			"buttons" : [
				{
					text: 'Exportar PDF',
					extend: 'pdfHtml5',
					filename: 'VeiculosRecolhidos',
					orientation: 'landscape', //portrait or landscape
					pageSize: 'A4', //A3 , A5 , A6 , legal , letter
					className :'btn bg-navy',
					exportOptions: {
						columns: ':visible',
						search: 'applied',
						order: 'applied'
					}
				},
				{
					text: 'Exportar Excel',
					className :'btn bg-navy',
					extend: 'excelHtml5'
				}
			],

			"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json",
				"decimal": ",",
				"thousands": ".",
			},
			"responsive": true,
			"paging" : false,
			"lengthChange" : true,
			"searching" : true,
			"ordering" : false,
			"info" : true,
			"autoWidth" : true
		});
	}

	$('.buttons-html5').addClass('btn-primary');


}

function BuscaReboqueFormulario(cod_reboque) {

	$.post("../model/Reboques.php", {
		acao : 'Busca_Reboque_Formulario',
		Cod_Reboque : cod_reboque
	}, function(data) {

		$('#Txt_Codigo').val(cod_reboque);
		$('#ATxt_Placa').val(data['Html']['Placa']);
		$('#AlterarReboque').modal("show");
	}, "json");

}

function PainelEstoqueAtual() {

    $.post("../model/Relatorios.php", {
        acao : 'Busca_Painel_Estoque',
    }, function(data) {

        $('.QtdRecolhido').html(data['QtdRecolhido']);


    }, "json");

}
function PainelVeiculoAtual() {

    $.post("../model/Relatorios.php", {
        acao : 'Busca_Veiculo_Estoque',
    }, function(data) {

        $('.DadosRecolhidos').append(data['Recolhido']);
        $('.DadosLiberados').append(data['Liberado']);
        }, "json");

}

function EstoqueAtual() {

    $.post("../model/Relatorios.php", {
        acao : 'Busca_EstoqueAtual',
    }, function(data) {


    }, "json");

}

function BuscaRelatoriosTabela() {

    $.post("../model/Relatorios.php", {
        acao : 'Busca_Relatorios',
		DataInicio : $('#DtInicio').val(),
		DataFim    : $('#DtFim').val(),
		Status     : $('#Status').val()
    }, function(data) {

		tabelaBuscaRelatorios.clear();
        for (var i = 0; i < data['Html'].length; i++) {
			tabelaBuscaRelatorios.row.add([data['Html'][i]['Grv'],data['Html'][i]['Placa'],data['Html'][i]['Chassi'],
				data['Html'][i]['MarcaModelo'],data['Html'][i]['TipoVeiculo'],data['Html'][i]['Autoridade'],data['Html'][i]['MatAgente'],
                data['Html'][i]['NomeAgente'],data['Html'][i]['DataRemocao'],
				data['Html'][i]['DataLiberacao'],data['Html'][i]['Cor'],data['Html'][i]['UsoReboque']]);
        }
		tabelaBuscaRelatorios.draw();
    }, "json");


}

function BuscaRelatoriosTabelaAgentes() {

	$.post("../model/Relatorios.php", {
		acao : 'Busca_RelatoriosAgentes',
		DataInicio : $('#DtInicio').val(),
		DataFim    : $('#DtFim').val(),
        Status     : $('#Status').val()
	}, function(data) {
		tabelaBuscaAgentes.clear();
		for (var i = 0; i < data['Html'].length; i++) {
			tabelaBuscaAgentes.row.add([data['Html'][i]['Agente'],data['Html'][i]['Tipo'],data['Html'][i]['Quantidade']]);
		}
		tabelaBuscaAgentes.row.add([ '<b >REFERENTE  DATA : ' +data['DataRemocao'],'<b >TOTAL','<b>'+data['Total']]);

		tabelaBuscaAgentes.draw();
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



//função para cadastrar Reboque
function SalvaReboque() {

	$('#FrmSalvarReboque').ajaxForm({
		url : '../model/Reboques.php',
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

	$('#FrmAlterarReboque').ajaxForm({
		url : '../model/Reboques.php',
		data : {

			acao : 'Alterar_Reboque'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarReboque').modal('hide');
				BuscaReboqueTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirReboque(Cod_Reboque){

	$.post("../model/Reboques.php", {
		acao : 'Exclui_Reboque',
        Cod_Reboque : Cod_Reboque
	}, function(data) {
		if(data['Cod_error']==0){
			BuscaReboqueTabela();
		}
	}, "json");

}

