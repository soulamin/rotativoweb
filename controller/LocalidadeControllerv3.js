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
    BuscalocalidadeTabela();
    ComboboxFiscal();

});


//Botão para Localidade
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
    SalvaLocalidade();

});


//Botão para Localidade
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
    AlteraLocalidade();

});

//Botão para Localidade
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
    BuscaLocalidadeFormulario($(this).attr("codigo"));
});

//Botão para Localidade
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
    ExcluirLocalidade($(this).attr("codigo"));

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

//Botão para Validar CPF
$(document).off("blur", "#LCPF");
$(document).on("blur", "#LCPF", function() {
    var CPF = $(this).val().replace('.','');
    var CPF = CPF.replace('.','');
    var CPF = CPF.replace('-','');

    var validarCPF = ValidaCPF(CPF);
    if(validarCPF==false){
        $(this).val("");

    }
});


//Botão para Busca Atendiemnto
$(document).off("click", "#BtnBuscaAtendimento");
$(document).on("click", "#BtnBuscaAtendimento", function() {
    if ($('#Patio').val()=='#'){
        alert("POR FAVOR,SELECIONE UM PÁTIO!");
    }else{
        BuscaAtendimento($('#Tipo').val(),$('#Dados').val(),$("#Patio").val());

    }
});


//Botão para Localidade
$(document).off("click", "#btnLocalidade");
$(document).on("click", "#btnLocalidade", function() {
    $("#IncluirLocalidade").modal("show");

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

function BuscalocalidadeTabela() {

    $.post("../model/Localidade.php", {
        acao : 'Busca_Localidade_Tabela',

    },function(data) {
        tabelaBuscaFiscal.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaFiscal.row.add([data['Html'][i]['Endereco'],data['Html'][i]['QtdVagas'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaFiscal.draw();
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
        acao : 'Combobox_Local',
        Txt_Fiscal:'%'
    }, function(data) {
        $('.Local').html(data['Html']);

    }, "json");

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

function BuscaEnderecop(cep) {
    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        if (!("erro" in dados)) {
            //Atualiza os campos com os valores da consulta.
            $("#PEndereco").val(dados.logradouro);
            $("#PBairro").val(dados.bairro);
            $("#PCidade").val(dados.localidade);
            $("#PUf").val(dados.uf);

        } //end if.

    });
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

//função para cadastrar Localidade
function SalvaLocalidade() {

    $('#FrmSalvarLocalidade').ajaxForm({
        url : '../model/Localidade.php',
        data : {
            acao : 'Salva_Localidade'

        },
        dataType : 'json',
        success : function(data) {
            if (data['Cod_Error'] == 0) {
                limpacampos();
                $('#IncluirLocalidade').modal('hide');
                BuscalocalidadeTabela();

            }
            $('.msg').html(data['Html']);
        }
    });

}
//função para cadastrar Localidade
function AlteraLocalidade() {

    $('#FrmAlterarLocalidade').ajaxForm({
        url : '../model/Localidade.php',
        data : {
            acao : 'Altera_Localidade'

        },
        dataType : 'json',
        success : function(data) {
            if (data['Cod_Error'] == 0) {
                limpacampos();
                $('#AlterarLocalidade').modal('hide');
                BuscalocalidadeTabela();

            }
            $('.msg').html(data['Html']);
        }
    });

}

function BuscaLocalidadeFormulario(cod_localidade) {

	$.post("../model/Localidade.php", {
		acao : 'Busca_Localidade_Formulario',
		Cod_Localidade : cod_localidade
	}, function(data) {

		$('#Txt_Codigo').val(cod_localidade);
		$('#ATxt_Cep').val(data['Html']['Cep']);
        $('#ATxt_Endereco').val(data['Html']['Endereco']);
        $('#ATxt_Bairro').val(data['Html']['Bairro']);
        $('#ATxt_Cidade').val(data['Html']['Cidade']);
        $('#ATxt_Uf').val(data['Html']['Uf']);
        $('#ATxt_QtdVagas').val(data['Html']['QtdVagas']);
		$('#AlterarLocalidade').modal("show");
	}, "json");

}

function ExcluirLocalidade(Cod_Localidade){

	$.post("../model/Localidade.php", {
		acao : 'Exclui_Localidade',
		Cod_Localidade : Cod_Localidade
	}, function(data) {
		if(data['Cod_error']==0){
			BuscalocalidadeTabela();
		}
	}, "json");

}



function Imprimirformulario() {

    newWindow = window.open("../Relatorios/Retirada", "_blank","toolbar=no, scrollbars=no, resizable=yes, menubar=no,titlebar=no, top=250, left=500, width=560, height=440");
    if(newWindow)return false;

}







