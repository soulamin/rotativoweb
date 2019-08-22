/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaFiscal= null;

$(".Celular").inputmask({
	mask : ["(99)9999-9999", "(99)99999-9999"],
	keepStatic : true
});

$(".Telefone").inputmask({
    mask : ["(99)9999-9999", "(99)99999-9999"],
    keepStatic : true
});
$(".Real").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
$(".Cep").inputmask("99999-999");
$(".CPF").inputmask("999.999.999-99");
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
    limpacampos();
    instanciaTabelaBusca();
    BuscaFiscalTabela();
    ComboboxFiscal();
    Combobox_Local();

});
//Botão para Calcula Dinheiro Cartao
$(document).off("blur", "#Vl1");
$(document).on("blur", "#Vl1", function() {
    CalculaDinheiroCartao($('#ValorTotal').val(),$(this).val(),'Vl1');
});

//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
    SalvaLocalFiscal();
});

//Botão para Excluir Cadastro
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
    ExcluirLocalFiscal($(this).attr("codigo"));
});

//Botão para Editar LocalFiscal
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	BuscaLocalFiscalFormulario($(this).attr("codigo"));
});



//Botão para Validar CPF
$(document).off("blur", "#Cpf");
$(document).on("blur", "#Cpf", function() {
    var CPF = $(this).val().replace('.','');
    var CPF = CPF.replace('.','');
    var CPF = CPF.replace('-','');

    var validarCPF = ValidaCPF(CPF);
    if(validarCPF==false){
        $(this).val("");
        alert('CPF INVÁLIDO!!')

    }
});



//Botão para Insere Lacre
$(document).off("click", "#btnFiscal");
$(document).on("click", "#btnFiscal", function() {
    $("#IncluirFiscal").modal("show");

});

//Botão para Buscar ENDEREÇO CEP
$(document).off("blur", ".Cep");
$(document).on("blur", ".Cep", function() {
	BuscaEndereco($(this).val().replace('-',''));
});


//Botão para Buscar ENDEREÇO CEP
$(document).off("blur", "#PCep");
$(document).on("blur", "#PCep", function() {
    BuscaEnderecop($(this).val().replace('-',''));
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

    if (tabelaBuscaFiscal != null) {
        tabelaBuscaFiscal.destroy();
        tabelaBuscaFiscal = null;
    } else {
        tabelaBuscaFiscal = $('#TabelaFiscal').DataTable({
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

function BuscaFiscalTabela() {

    $.post("../model/LocalFiscal.php", {
        acao : 'Busca_LocalFiscal_Tabela',

    },function(data) {
        tabelaBuscaFiscal.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaFiscal.row.add([data['Html'][i]['Nome'],data['Html'][i]['Rua'],data['Html'][i]['Status'],
                data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaFiscal.draw();
    }, "json");

}

//localfiscal formulario
function BuscaLocalFiscalFormulario(Cod_localfiscal) {

	$.post("../model/LocalFiscal.php", {
		acao : 'Busca_LocalFiscal_Formulario',
		Cod_LocalFiscal : Cod_localfiscal
	}, function(data) {

		$('#Txt_Codigo').val(Cod_localfiscal);
		$('#ATxt_Fiscal').val(data['Html']['Fiscal']);
        $('#ATxt_Local').val(data['Html']['Local']);
		$('#EditarLocalFiscal').modal("show");
	}, "json");

}
//busca fiscal cadastrada  para a combobox
function ComboboxFiscal() {

    $.post('../model/Usuarios.php', {
        acao : 'Combobox_Fiscal'
    }, function(data) {
        $('.Fiscal').html(data['Html']);

    }, "json");

}

//busca  cadastrada  para a combobox
function Combobox_Local() {

    $.post('../model/Localidade.php', {
        acao : 'Combobox_Localidade',
    }, function(data) {
        $('.Local').html(data['Html']);
    }, "json");

}

function BuscaEndereco(cep) {
    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

        if (!("erro" in dados)) {
            //Atualiza os campos com os valores da consulta.
            $(".Rua").val(dados.logradouro);
            $(".Bairro").val(dados.bairro);
            $(".Cidade").val(dados.localidade);
            $(".Uf").val(dados.uf);

        } //end if.
    });
}


//limpa os campos
function limpacampos() {
	$(".TextArea").val("");
	$("input[type=text]").val("");
    $("input[type=time]").val("");
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


//validar CPF
function ValidaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
    //strCPF  = RetiraCaracteresInvalidos(strCPF,11);
    if (strCPF == "00000000000" || strCPF == "11111111111" )
        return false;
    for (i=1; i<=9; i++)
        Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11))
        Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) )
        return false;
    Soma = 0;
    for (i = 1; i <= 10; i++)
        Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11))
        Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) )
        return false;
    return true;
}

//função para cadastrar LocalFiscal
function SalvaLocalFiscal() {

    $('#FrmSalvarLocalFiscal').ajaxForm({
        url : '../model/LocalFiscal.php',
        data : {
            acao : 'Salva_LocalFiscal'

        },
        dataType : 'json',
        success : function(data) {
            if (data['Cod_Error'] == 0) {
                limpacampos();
                BuscaFiscalTabela();
                $('#IncluirFiscal').modal('hide');
            }else {
                alert("Existe Campo Pendente!")
            }

            $('.msg').html(data['Html']);
        }
    });

}

function ExcluirLocalFiscal(Cod_localfiscal){

	$.post("../model/LocalFiscal.php", {
		acao : 'Exclui_LocalFiscal',
        Cod_LocalFiscal : Cod_localfiscal
	}, function(data) {
		if(data['Cod_Error']==0){
			BuscaFiscalTabela();
		}
	}, "json");

}










