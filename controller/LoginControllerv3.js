/*=======================================================================================
*
*
* VARIABLE
*
*
=======================================================================================*/
var mensagem =$("#msg");

$(".Celular").inputmask("(99)99999-9999");


$(".Placa").inputmask({
	mask : ["AAA9999", "AAA9A99"],
	keepStatic : true
});


$(".CPF").inputmask("999.999.999-99");

/*=======================================================================================
*
*
* CALL INITIALIZE
*
*
=======================================================================================*/
$(document).ready(function(){
     Cookie();
      });


/*=======================================================================================
*
*
* ACTIONS
*
*
=======================================================================================*/

//Botão para Entrar no sistema
$(document).off("click","#btnEntrar");
$(document).on("click","#btnEntrar", function() {
    logar();
});

//Botão para Entrar no sistema
$(document).off("click","#btnSalvar");
$(document).on("click","#btnSalvar", function() {
    SalvaUsuario();
});
//Botão para Entrar no sistema
$(document).off("click","#btnEnviarEmail");
$(document).on("click","#btnEnviarEmail", function() {
    EsqueciSenha($('#ETxt_Email').val());
});

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

//Botão para Entrar no sistema
$(document).off("keypress","#btnEntrar");
$(document).on("keypress", function(event) {
	if(event.keyCode==13){
		logar();
	}
});


//Botão para Retornar
$(document).off("click","#btnretorno");
$(document).on("click","#btnretorno", function() {
 retornarpagina();
});


  

/*=======================================================================================
*
*
* FUNCTIONS
*
*
=======================================================================================*/

//Entrar no sistema
function logar(){

    $('#FrmLogar').ajaxForm({
        url: 'model/Login.php',
        data: {
            acao: 'Logar',
            login: $("#Txt_Login").val(),
            senha: $("#Txt_Senha").val()
        },
        dataType : 'json',
        success : function(data) {

            if (data['Cod_Error'] == 0) {

                switch (data['Tipo']){

                    case 'A' :
                            window.location.href = "Painel/";
                        break;
                    case 'U' :
                            window.location.href = "MeuTicket/";
                        break;
                    case 'F' :
                            window.location.href = "Gerenciar/";
                        break;
                    case 'G' :
                            window.location.href = "Ticket/";
                        break;
                   
                }


            }  else{
                limpacampos();
                $("#msg").html(data['html']);
            }
        }
        });
}


function Cookie(){
    $.post("model/Login.php", {
		acao : 'Cookie'
	}, function(data) {
        if (data['Cod_Error'] == 0) {

            switch (data['Tipo']){

                case 'A' :
                        window.location.href = "Painel/";
                    break;
                case 'U' :
                        window.location.href = "MeuTicket/";
                    break;
                case 'F' :
                        window.location.href = "Gerenciar/";
                    break;
                case 'G' :
                        window.location.href = "Ticket/";
                    break;
               
            }
        }  else{
         //   limpacampos();
           // $("#msg").html(data['html']);
        }
	}, "json");

}



//função para cadastrar Usuario
function SalvaUsuario() {

	$('#FrmSalvarUsuario').ajaxForm({
		url : 'model/Usuarios.php',
		data : {
			acao : 'Salva_UsuarioCadastro'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
			
                $('#IncluirUsuario').modal('hide');
                alert("Cadastro efetuado com Sucesso");
				window.history.go(0);
			}else if(data['Cod_Error'] == 1){
                alert("Por favor preencher todos os campos");
            }else{

                alert("CPF já cadastrado.");
            }
			
		}
	});

}


//limpa os campos
function limpacampos() {
    $(":text").val("");
    $(":password").val("");
    $(":radio").prop({checked: false});
    $("input[type=text]").val("");
    $("input[type=email]").val("");
    $("input[type=password]").val("");
    $("input[type=number]").val("");
    $("input[type=date]").val("");

}

function EsqueciSenha(email){
    $.post("model/Usuarios.php", {
		acao : 'EsqueciaSenha',
		Email : email
	}, function(data) {
       
           if(data['Cod_Error']=='1'){
            $('#EsqueciaSenha').modal('hide'); 
              alert("Não Encontramos esse Email cadastrado.");
              
           }else{
            $('#EsqueciaSenha').modal('hide'); 
             alert("Foi enviado um Email com seu Usuário e Senha Cadastrado");
           }
           window.history.go(0);
           limpacampos();
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