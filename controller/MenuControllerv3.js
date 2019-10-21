/*=======================================================================================
*
*
* VARIABLE
*
*
=======================================================================================*/

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
$(document).ready(function(){
   // Cache.delete();
    Valida();
    $("input[type=text]").val($(this).val().toUpperCase());
    
    });


//Botão para Menu Principal
$(document).off("click",'.btnMenuPrincipal');
$(document).on("click",'.btnMenuPrincipal', function() {
    location.href ='../Menu';
});

//Botão para Pagamentos
$(document).off("click",'.btnPagamentos');
$(document).on("click",'.btnPagamentos', function() {
    location.href ='../Pagamentos';
});

//Botão para Conferente
$(document).off("click",'.btnAtendimento');
$(document).on("click",'.btnAtendimento', function() {
    location.href ='../Atendimento/';
});
//Botão para Ticket
$(document).off("click",'.btnTicket');
$(document).on("click",'.btnTicket', function() {
    location.href ='../Ticket/';
});

//Botão para Ticket
$(document).off("click",'.btnAjudaSuporte');
$(document).on("click",'.btnAjudaSuporte', function() {
      location.href ='../Ajuda/';
});
//Botão para Cliente
$(document).off("click",'.btnCliente');
$(document).on("click",'.btnCliente', function() {
    location.href ='../LocalFiscal/';
});

//Botão para Cliente
$(document).off("click",'.btnRelatorio');
$(document).on("click",'.btnRelatorio', function() {
    location.href ='../Relatorios/';
});

//Botão para Taxas
$(document).off("click",'.btnTaxa');
$(document).on("click",'.btnTaxa', function() {
    location.href ='../Taxas/';
});
//Botão para LocalFiscal
$(document).off("click",'.btnLocalFiscal');
$(document).on("click",'.btnLocalFiscal', function() {
    location.href ='../LocalFiscal/';
});

//Botão para Gerenciar Tickts
$(document).off("click",'.btnGerenciar');
$(document).on("click",'.btnGerenciar', function() {
    location.href ='../Gerenciar/';
});

//Botão para Log Digital
$(document).off("click",'.btnFormaPg');
$(document).on("click",'.btnFormaPg', function() {
    location.href ='../FormaPg/';
});

//Botão para Guardador
$(document).off("click",'.btnGuardador');
$(document).on("click",'.btnGuardador', function() {
    location.href ='../Guardador/';
});

//Botão para Ticket
   $(document).off("click",'.btnEstacionamento');
   $(document).on("click",'.btnEstacionamento', function() {
    location.href ='../Ticket/';
   $(this).attr('class','active');
});

//Botão para Taxas
$(document).off("click",'.btnLocalidade');
$(document).on("click",'.btnLocalidade', function() {
    location.href ='../Localidade/';
});

//Botão para Empresas
$(document).off("click",'.btnEmpresa');
$(document).on("click",'.btnEmpresa', function() {
    location.href ='../Empresas/';
});

//Meu Ticket
$(document).off("click",'.btnMeuTicket');
$(document).on("click",'.btnMeuTicket', function() {
    location.href ='../MeuTicket/';
});

//Botão para  Informacao
$(document).off("click",'.btnInformacao');
$(document).on("click",'.btnInformacao', function() {
    location.href ='../Informacao/';
});


//Botão para Perfil
$(document).off("click",'.btnPerfil');
$(document).on("click",'.btnPerfil', function() {
    location.href ='../Perfil/';
});

//Botão para Parametros
$(document).off("click",'.btnHistorico');
$(document).on("click",'.btnHistorico', function() {
    location.href ='../Historico/';
});



//Botão para Historico fiscal
$(document).off("click",'.btnHistoricoFiscal');
$(document).on("click",'.btnHistoricoFiscal', function() {
    location.href ='../Historico/';
});

//Botão para Notificacao
$(document).off("click",'.btnNotificacao');
$(document).on("click",'.btnNotificacao', function() {
    location.href ='../Notificacao/';
});

//Botão para Tipo de Veiculos
$(document).off("click",'.btnTipoVeiculo');
$(document).on("click",'.btnTipoVeiculo', function() {
    location.href ='../TipoVeiculo/';
});

//Botão para Usuarios
$(document).off("click",'.btnUsuario');
$(document).on("click",'.btnUsuario', function() {
    location.href ='../Usuarios/';
});


//Botão para  Status Veiculo
$(document).off("click",'.btnStatusVeiculo');
$(document).on("click",'.btnStatusVeiculo', function() {
    location.href ='../StatusVeiculo/';
});

//Botão para Recarga
$(document).off("click",'.btnRecarga');
$(document).on("click",'.btnRecarga', function() {
    location.href ='../Recarga/';
});

//Botão para Tipo Veículo
$(document).off("click",'.btnPgPendente');
$(document).on("click",'.btnPgPendente', function() {
    location.href ='../PagamentoPendente/';
});

//Botão para Motivo
$(document).off("click",'.btnMotivo');
$(document).on("click",'.btnMotivo', function() {
    location.href ='../Motivos/';
});


//Botão para Painel
$(document).off("click",'.btnPainel');
$(document).on("click",'.btnPainel', function() {
    location.href ='../Painel/';
});


//Botão para  Taxas
$(document).off("click",'.btnAlteraSenha');
$(document).on("click",'.btnAlteraSenha', function() {
    $('#AlteraSenha').modal('show');

});
//Botão para  Altera Senha
$(document).off("click",'#BtnAltSenha');
$(document).on("click",'#BtnAltSenha', function() {
    AlteraSenhaUsuario($('#SenhaAtual').val(),$('#SenhaNova').val());

});

//Botão para Sair
$(document).off("click",'#btnSair');
$(document).on("click",'#btnSair', function() {
    Sair();

});


/*=======================================================================================
*
*
* FUNCTIONS
*
*
=======================================================================================*/


//retorna na pagina anterior
function retornarpagina(){
    window.history.go(-1);
}


function Sair(){
    $.post("../model/Menu.php",{
            acao : 'Sair'
        }, function(data) {
            if(data['Cod_Error']==1){
                window.location.href = "../";
            }
        },
        "json"
    );
}

function Valida(){
    $.post("../model/Menu.php",{
            acao : 'Validar'
        }, function(data) {
            if(data['Cod_Error']==1){
                window.location.href = "../";
            }else{
                $(".LoginUsuario").append(data['Html']);
                $("#MenuLateral").html(data['MenuLateral']);
                $("#MenuTopoDireita").append(data['MenuTopoDireita']);
                $("#MenuTopo").append(data['MenuTopo']);

            }
        },
        "json"
    );
}





function AlteraSenhaUsuario(SenhaAtual,SenhaNova){
    $.post("../model/Login.php",{
            acao : 'AlterarSenha_Usuario',
            SenhaAtual : SenhaAtual,
            SenhaNova  : SenhaNova
        }, function(data) {
            if(data['Cod_Error']==1) {

                   alert("SENHA ALTERADA COM SUCESSO!");
                    $('#SenhaAtual').val('');
                    $('#SenhaNova').val('');
                    $('#AlteraSenha').modal('hide');
            }else if(data['Cod_Error']==3){
                alert("EXISTE CAMPO VAZIO!");
            }else{
                alert("SENHA ATUAL, NÃO CONFERE DIGITADA");
                $('#SenhaAtual').val('');
                $('#SenhaNova').val('');
            }
        },
        "json"
    );
}

//if (Android) {


  //  function callFromActivity(msg) {
   //     document.getElementById("mytext").innerHTML = "msg";
    //}


    //function myFunction() {
        // document.getElementById("mytext").innerHTML = "xxx";

      //  Android.showToast("IMPRIMINDO xxx");
   // }

//}