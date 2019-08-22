/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaUsuario = null;
$(".Celular").inputmask({
	mask : ["(99)9999-9999", "(99)99999-9999"],
	keepStatic : true
});
$(".Telefone").inputmask("(99)9999-9999");
$(".Cpf").inputmask("999.999.999-99");
$("#txtDataAte").inputmask("99/99/9999");
//$('.SenhaMostrar').hide();
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
    BuscaUsuarioTabela();

	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#AlterarUsuario').modal('show');
	BuscaUsuarioFormulario($(this).attr("codigo"));
});


//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});



//Botão para Excluir Usuario
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirUsuario($(this).attr("codigo"));
	}
	BuscaUsuarioTabela();
});

//Mostra e Esconde  a Senha
$("#Txt_Mostra").on("ifToggled",function() {
	$('#Txt_Senha').toggle();
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	SalvaUsuario();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	AlteraUsuario();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnUsuario");
$(document).on("click", "#btnUsuario", function() {
	$('.msg').empty();
	$('#IncluirUsuario').modal('show');
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

	if (tabelaBuscaUsuario != null) {
		tabelaBuscaUsuario.destroy();
		tabelaBuscaUsuario = null;
	} else {
		tabelaBuscaUsuario = $('#TabelaUsuarios').DataTable({
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



function BuscaUsuarioFormulario(cod_usuario) {

	$.post("../model/Usuarios.php", {
		acao : 'Busca_Usuario_Formulario',
		Cod_Usuario: cod_usuario
	}, function(data) {
		$('#AlterarUsuario').modal("show");
      $("#btnResetarSenha").attr("C",data['Html']['Codigo']);
	$('#ATxt_Codigo').val(data['Html']['Codigo']);
	$('#ATxt_Nome').val(data['Html']['Nome']);
    $('#ATxt_Login').val(data['Html']['Login']);
	$('#ATxt_Email').val(data['Html']['Email']);
	$('#ATxt_Celular').val(data['Html']['Celular']);
	$('#ATxt_Telefone').val(data['Html']['Telefone']);
	$('#ATxt_Cpf').val(data['Html']['Cpf']);

	}, "json");

}

//busca para colocar na tabela de Usuarios
function BuscaUsuarioTabela() {

	$.post("../model/Usuarios.php", {
		acao : 'Busca_Usuarios_Tabela',

	}, function(data) {
        tabelaBuscaUsuario.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaUsuario.row.add([data['Html'][i]['Nome'],data['Html'][i]['Login'],data['Html'][i]['Nivel'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaUsuario.draw();
    }, "json");
	}

//limpa os campos
function limpacampos() {
    $(".TextArea").val("");
    $(":text").val("");
    $(":password").val("");
	$(".Email").val("");
    $(".ordem").val("1");
	$("input[name~='Txt_Email']").val("");
}

//retorna na pagina anterior
function retornarpagina() {
	window.history.go(-1);
}

function CheckRadioPersonalizado(){
	$('.Senha').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue',
		increaseArea: '20%' // optional
		});
}

//função para cadastrar Usuario
function SalvaUsuario() {

	$('#FrmSalvarUsuario').ajaxForm({
		url : '../model/Usuarios.php',
		data : {
			acao : 'Salva_Usuario'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirUsuario').modal('hide');
				BuscaUsuarioTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

//Botão para Validar CPF
$(document).off("blur", ".CPF");
$(document).on("blur", ".CPF", function() {
    var CPF = $(this).val().replace('.','');
    var CPF = CPF.replace('.','');
    var CPF = CPF.replace('-','');

    var validarCPF = ValidaCPF(CPF);
    if(validarCPF==false){
        $(this).val("");

    }
});

function ExcluirUsuario(Cod_Usuario){

	$.post("../model/Usuarios.php", {
		acao : 'Exclui_Usuario',
		Cod_Usuario : Cod_Usuario
	}, function(data) {
		if(data['Cod_error']==0){
			BuscaUsuarioTabela();
		}
	}, "json");

}

function ResetarSenha(Cod_Usuario){

    $.post("../model/Usuarios.php", {
        acao : 'Resetar_Senha',
        Cod_Usuario : Cod_Usuario
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}
//função para Alterar Perfil
function AlteraUsuario(){

	$.post("../model/Usuarios.php", {
		acao : 'Altera_Usuario',
		ATxt_Codigo	    : $('#ATxt_Codigo').val(),
		ATxt_Nome  		: $('#ATxt_Nome').val(),
		ATxt_Login 		: $('#ATxt_Login').val(),
		ATxt_Tipo 		: $('#ATxt_Tipo').val(),
		ATxt_Telefone 	: $('#ATxt_Telefone').val(),
		ATxt_Celular 	: $('#ATxt_Celular').val(),
		ATxt_Cpf     	: $('#ATxt_Cpf').val(),
		ATxt_Email 	    : $('#ATxt_Email').val()
      
	}, function(data) {
		if (data['Cod_Error'] == 0) {
			$('#AlterarUsuario').modal("hide");
			limpacampos();
			BuscaUsuarioTabela();
		}
	}, "json");

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