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

$(".Telefone").inputmask("(99)9999-9999");
$(".CEP").inputmask("99999-999");

/*=======================================================================================
*
*
* CALL INITIALIZE
*
*
=======================================================================================*/
//Botão para altera faturamento
$(document).off("change", "#Guardador");
$(document).on("change", "#Guardador", function() {
    BuscaPainel($(this).val());
});

//Botão fechamento de caixa
$(document).off("click", "#btnFechaCaixa");
$(document).on("click", "#btnFechaCaixa", function() {
    $('#ExibirRelatorio').prop("hidden",false);
    $('#Relatorio').prop("src","../FechamentoCaixa/index.php?F="+$('#Guardador').val()+"&D="+$('#DataEnt').val());
});
/*=======================================================================================
*
*
* ACTIONS
*
*
=======================================================================================*/
//inicializa a tabela
$(document).ready(function() {
    ComboboxFiscal();
    BuscaPainel($('#Guardador').val());
});

    
//busca fiscal cadastrada  para a combobox
function ComboboxFiscal() {

    $.post('../model/Usuarios.php', {
        acao : 'Combobox_Fiscal'
    }, function(data) {
        $('#Guardador').html(data['Html']);

    }, "json");

}
//busca as Empresas cadastrada  para a combobox
function BuscaPainel(guardador) {

	$.post('../model/Guardador.php', {
		acao : 'Busca_Painel',
        Guardador:guardador
	}, function(data) {
        $('.TicketNotificado').html(data['TicketNotificado']);
        $('.QtdTicketDiaria').html(data['QtdTicketDiaria']);
        $('.QtdTicketSemanal').html(data['QtdTicketSemanal']);
        $('.QtdTicketMensal').html(data['QtdTicketMensal']);
        $('.QtdLiberacaoDiariaG').html(data['QtdEvasaoDiaria']);
        $('.QtdLiberacaoSemanalG').html(data['QtdEvasaoSemanal']);
        $('.QtdLiberacaoMensalG').html(data['QtdEvasaoMensal']);
        $('.ValorTotalDiaria').html(data['ValorTotalDiario']);
        $('.ValorTotalSemanal').html(data['ValorTotalSemanal']);
        $('.ValorTotalMensal').html(data['ValorTotalMensal']);
      

// Radialize the colors
Highcharts.setOptions({
    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    })
});

// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Vaga Disponivel ou Ocupada '
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                connectorColor: 'silver'
            }
        }
    },
    
    series: [{
        name: 'Vagas',
        data: [
            { name: 'Disponivel', y: data['PorcDisponivel'] ,color: '#09bd1e' },
            { name: 'Ocupada', y: data['PorcOcupada'],color: '#f03e11' },
         
        ]
    }]
});

	}, "json");
}


//busca as Empresas cadastrada  para a combobox
function Busca_PainelSelecionado(id_patio) {

    $.post('../model/Painel.php', {
        acao : 'Busca_PainelSelecionado',
        Mes : $('.SelecioneMes').val(),
        Id_Patio : id_patio
    }, function(data) {

        $('.ValorTotalMensal'+id_patio).html(data['ValorTotalMensalSelecionado']);

    }, "json");
}


//busca as Empresas cadastrada  para a combobox
function Busca_PainelSelecionadoGrupo() {

    $.post('../model/Painel.php', {
        acao : 'Busca_PainelSelecionadoGrupo',
        Mes : $('.SelecioneMesGrupo').val(),

    }, function(data) {

        $('.ValorTotalMensalG').html(data['ValorTotalMensalSelecionadoG']);

    }, "json");
}

/*=======================================================================================
 *
 *
 * FUNCTIONS
 *
 *
 =======================================================================================*/
function instanciaTabelaBusca() {

	if (tabelaBuscaPonto != null) {
		tabelaBuscaPonto.destroy();
		tabelaBuscaPonto = null;
	} else {
		tabelaBuscaPonto = $('#TabelaPontos').DataTable({
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


function BuscaPontoTabela() {
	$.post("../model/Pontos.php", {
		acao : 'Busca_Ponto_Tabela',
	}, function(data) {
		$('.ResultadoPonto').empty();
		$('.ResultadoPonto').html(data['Html']);
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

