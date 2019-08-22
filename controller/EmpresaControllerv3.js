/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
tabelaBuscaEmpresa= null;

$(".Celular").inputmask({
	mask : ["(99)9999-9999", "(99)99999-9999"],
	keepStatic : true
});
$(".CNPJ").inputmask("99.999.999/9999-99");
$(".Telefone").inputmask("(99)9999-9999");
$(".CEP").inputmask("99999-999");
//$(".Dinheiro").maskMoney({showSymbol:true, symbol:"", decimal:",", thousands:"."});
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
*
=======================================================================================*/

//inicializa a tabela
$(document).ready(function() {
    instanciaTabelaBusca();
	BuscaEmpresaTabela();
});

//Botão para Editar Admin
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	Busca_Empresa_Formulario($(this).attr("codigo"));
});

//Botão para Excluir Empresa
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {

	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirEmpresa($(this).attr("codigo"));
			}
	BuscaEmpresaTabela();
	
});

//Botão para Excluir Arquivo Logo
$(document).off("click", "#BtnExcluirLogo");
$(document).on("click", "#BtnExcluirLogo", function() {
    if (confirm("Tem certeza que deseja excluir ? ")) {
        ExcluirLogo($(this).attr("codigo"));
    }
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnEmpresa");
$(document).on("click", "#btnEmpresa", function() {
	$('.msg').empty();
	$('#IncluirEmpresa').modal('show');
});


//Botão para Buscar ENDEREÇO CEP
$(document).off("blur", ".CEP");
$(document).on("blur", ".CEP", function() {
	BuscaEndereco($(this).val().replace('-',''));

});

//Validar campo Cnpj
$(document).off("blur", ".CNPJ");
$(document).on("blur", ".CNPJ", function() {
	var CNPJ = $(this).val()
	var validarCNPJ = validaCnpj(CNPJ);
	if(validarCNPJ==false){
		$('.CNPJ').val("");

	}
});

//Botão para Salvar Empresa
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaEmpresa();
});


//Botão para Alterar Empresa
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraEmpresa();
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

	if (tabelaBuscaEmpresa != null) {
		tabelaBuscaEmpresa.destroy();
		tabelaBuscaEmpresa = null;
	} else {
		tabelaBuscaEmpresa = $('#TabelaEmpresas').DataTable({
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

//Excluir Logo do cadastro do Empresas
function ExcluirLogo(Arquivo) {

    $.post("../model/Empresas.php", {
        acao: 'Exclui_Logo',
        Arquivo: Arquivo ,
        Codigo : $("#Txt_Codigo").val()
    }, function (data) {
        if (data['Cod_Error'] == 0) {
            $('#Logo').empty();
            $('#Logo').html(data['Arq_Logo']);
        }
    }, "json");

}
function Busca_Empresa_Formulario(cod_empresa) {

	$.post("../model/Empresas.php", {
		acao : 'Busca_Empresa_Formulario',
		Cod_Empresa : cod_empresa
	}, function(data) {
		$('#Txt_Codigo').val(cod_empresa);
		$('#ATxt_Nome').val(data['Html']['Nome']);
		$('#ATxt_Email').val(data['Html']['Email']);
		$('#ATxt_Telefone').val(data['Html']['Telefone']);
		$('#ATxt_Celular').val(data['Html']['Celular']);
		$('#ATxt_Cnpj').val(data['Html']['Cnpj']);
		$('#ATxt_Cep').val(data['Html']['Cep']);
		$('#ATxt_Logradouro').val(data['Html']['Logradouro']);
		$('#ATxt_Numero').val(data['Html']['Num']);
		$('#ATxt_Compl').val(data['Html']['Complemento']);
		$('#ATxt_Bairro').val(data['Html']['Bairro']);
		$('#ATxt_Cidade').val(data['Html']['Cidade']);
		$('#ATxt_Uf').val(data['Html']['Uf']);
		$('#Logo').html(data['Html']['Logo']);
		$('#AlterarEmpresa').modal("show");
	}, "json");

}

function BuscaEmpresaTabela() {

	$.post("../model/Empresas.php", {
		acao : 'Busca_Empresas_Tabela',

    },function(data) {
        tabelaBuscaEmpresa.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaEmpresa.row.add([data['Html'][i]['Empresa'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaEmpresa.draw();
    }, "json");

}

//limpa os campos
function limpacampos() {

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

//função para cadastrar Empresa
function SalvaEmpresa() {
	$('#FrmSalvarEmpresa').ajaxForm({
		url : '../model/Empresas.php',
		data : {
			acao : 'Salva_Empresa'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirEmpresa').modal('hide');
				BuscaEmpresaTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

//validar CNPJ
function validaCnpj(str){
		str = str.replace('.','');
		str = str.replace('.','');
		str = str.replace('.','');
		str = str.replace('-','');
		str = str.replace('/','');
		cnpj = str;
		var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
		digitos_iguais = 1;
		if (cnpj.length < 14 && cnpj.length < 15)
			return false;
		for (i = 0; i < cnpj.length - 1; i++)
			if (cnpj.charAt(i) != cnpj.charAt(i + 1))
			{
				digitos_iguais = 0;
				break;
			}
		if (!digitos_iguais)
		{
			tamanho = cnpj.length - 2
			numeros = cnpj.substring(0,tamanho);
			digitos = cnpj.substring(tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--)
			{
				soma += numeros.charAt(tamanho - i) * pos--;
				if (pos < 2)
					pos = 9;
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(0))
				return false;
			tamanho = tamanho + 1;
			numeros = cnpj.substring(0,tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--)
			{
				soma += numeros.charAt(tamanho - i) * pos--;
				if (pos < 2)
					pos = 9;
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(1))
				return false;
			return true;
		}
		else
			return false;
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

//função para Alterar Empresa
function AlteraEmpresa() {
	$('#FrmAlterarEmpresa').ajaxForm({
		url : '../model/Empresas.php',
		data : {
			acao : 'Altera_Empresa'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				BuscaEmpresaTabela();
				$('#AlterarEmpresa').modal('hide');
			}
			$('.msg').html(data['Html']);
		}
	});

}


function ExcluirEmpresa(Cod_Empresa){

	$.post("../model/Empresas.php", {
		acao : 'Exclui_Empresa',
		Cod_Empresa : Cod_Empresa
	}, function(data) {
			if(data['Cod_error']==0){
				BuscaEmpresaTabela();
			}
	}, "json");



}


