/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
 
$(".Val").inputmask("99/2099");
$(".CPF").inputmask("999.999.999-99");
$(".Cartao").inputmask("9999.9999.9999.9999");
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
	ComboboxTokenCartao();
    BotaoRecarga();
   Saldo();
  
});


//Botão para Excluir Cartao
$(document).off("click", "#btnExcluir");
$(document).on("click", "#btnExcluir", function() {
	if (confirm("Tem certeza que deseja excluir ? ")) {
		ExcluirCartao($('.TCartao').val());
			}
});

//Botão para Com Valores
$(document).off("click", ".BotaoRecarga");
$(document).on("click", ".BotaoRecarga", function() {
    SelecionarBotao($(this).attr('codigo'),$(this).attr('valor'));
});

//Botão para Com Valores
$(document).off("change", ".TCartao");
$(document).on("change", ".TCartao", function() {
	TipoCartao($(this).val());
});

//Botão para  Liberar Vaga
$(document).off("click", "#btnRenovaTicket");
$(document).on("click", "#btnRenovaTicket", function() {
    BuscaTicketInfo($(this).attr('codigo'));
   
});

//Botão para  Recarga
$(document).off("click", "#btnRecargaPg");
$(document).on("click", "#btnRecargaPg", function() {
	if(($('#Txt_Nome').val()=='') || ($('#Txt_Validade').val()=='') || ($('#Txt_Cartao').val()=='') ){
		$('#FalhaDados').modal('show');
	}else{
		PagamentosRecarga();
        $("#loader").modal('hide');
	}


   
});

//Botão para  Recarga
$(document).off("click", "#btnRecargaTk");
$(document).on("click", "#btnRecargaTk", function() {
	if($('#Txt_Cod').val()=='' ){
		$('#FalhaDados').modal('show');
	}else{
		PagamentosRecargaToken();
        $("#loader").modal('hide');
	}


   
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

 function SelecionarBotao(codigo,valor){
    $('.BotaoRecarga').removeClass("bg-warning");
     $('#'+codigo).addClass("bg-warning");
     $('#Taxas').val(codigo);
     $('#Txt_Recarga').val(valor);
}




function BotaoRecarga() {

    $.post("../model/Taxa.php", {
        acao : 'BotaoRecarga',
    
    }, function(data) {
       $('.Recarga').html(data['Html']);
    }, "json");

}

function ExcluirCartao(codtoken) {

    $.post("../model/Recarga.php", {
		acao : 'ExcluiToken',
		Cod_Token : codtoken
    
    }, function(data) {
		if(data['Cod_Error']==0){
			location.reload();
		}
		
    }, "json");

}

//busca as infracao cadastrada  para a combobox
function ComboboxTipoArea() {

	$.post('../model/TipoArea.php', {
		acao : 'Combobox_TipoArea'
	}, function(data) {
		//$('.TipoVeiculo').select2();
		$('.TipoArea').html(data['Html']);

	}, "json");

}
function TipoCartao(tipo) {
	if(tipo=='#'){
		$('.NToken').attr('hidden',true);
		$('.NCartao').attr('hidden',false);
	}else{
		$('.NCartao').attr('hidden',true);
		$('.NToken').attr('hidden',false);
	}

}



//busca as infracao cadastrada  para a combobox
function ComboboxTokenCartao() {

	$.post('../model/Usuarios.php', {
		acao : 'UsuarioToken'
	}, function(data) {

		$('.TCartao').html(data['Html']);
		TipoCartao($('.TCartao').val());
	}, "json");

}



function BuscaTaxaFormulario(CodTaxa) {

	$.post("../model/Taxa.php", {
		acao : 'Busca_Taxa_Formulario',
		Cod_Id : CodTaxa
	}, function(data) {
		$('#Txt_Codigo').val(CodTaxa);
        $('#ATxt_QtdHora').val(data['Html']['QtdHora']);
		$('#ATxt_Valor').val(data['Html']['Valor']);
		var TipoVeiculo = data['Html']['TipoVeiculo'];
		ComboBox_TipoVeiculo();
		ComboboxTipoArea();
		var TipoArea= data['Html']['TipoArea'];
	   $('#ATxt_TipoVeiculo').val(TipoVeiculo);
	   $('#ATxt_Area').val(TipoArea);
	   $('#AlterarTaxas').modal();
		
	}, "json");

}



//Salva Pagamento
function PagamentosRecargaToken() {

	$.ajax({
		url: '../model/Recarga.php',
		type: 'post',
		data: { 
			acao        : 'RecargaToken',
			
				Txt_Cod           :    $('#Txt_Cod').val(),
				Txt_Token		  :   $('.TCartao').val(),
				Txt_Recarga       :    $('#Txt_Recarga').val()
		},
		dataType: 'json',
        cache: false,
		beforeSend: function(){
		 // Show image container
		 $("#loader").modal('show');
		},
		success:function(data){
			// Hide image container

           switch(data['Cod_Error']){

			case 0 :
				$('#PgAprovado').modal('show');
                $("#loader").modal('hide');
				limpacampos();
				Saldo();
			break;
			case 1 :
				$('#PgNaoAprovado').modal('show');
                $("#loader").modal('hide');
				limpacampos();
				Saldo();
			 break;
			 case 5 :
					$("#loader").modal('hide');
				    window.alert('Erro na chave da Api de Pagamento!'); 
			 break;
		   }
		}
		 
	   });
	   $("#loader").modal('hide');

	} 

//Salva Pagamento
function PagamentosRecarga() {

	$.ajax({
		url: '../model/Recarga.php',
		type: 'post',
		data: { 
			acao        : 'Recarga',
				Txt_NomeCartao    :    $('#Txt_Nome').val(),
				Txt_Validade      :    $('#Txt_Validade').val(),
				Txt_Cod           :    $('#Txt_Cod').val(),
				Txt_Cartao        :    $('#Txt_Cartao').val(),
				Txt_Recarga       :    $('#Txt_Recarga').val()
		},
		dataType: 'json',
        cache: false,
		beforeSend: function(){
		 // Show image container
		 $("#loader").modal('show');
		},
		success:function(data){
			// Hide image container

           switch(data['Cod_Error']){

			case 0 :
					$("#loader").modal('hide');
				$('#PgAprovado').modal('show');
               
				limpacampos();
				Saldo();
			break;
			case 1 :
					$("#loader").modal('hide');
				$('#PgNaoAprovado').modal('show');
                
				limpacampos();
				Saldo();
			 break;
			 case 5 :
					$("#loader").modal('hide');
					window.alert('Erro na chave da Api de Pagamento!'); 			 
					break;
		   }
		}
		 
	   });
	   $("#loader").modal('hide');

	} 

function BuscaTaxaTabela() {

	$.post("../model/Taxa.php", {
		acao : 'Busca_Taxa_Tabela',

	}, function(data) {
        tabelaBuscaTaxa.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaTaxa.row.add([data['Html'][i]['Area'],data['Html'][i]['TipoTransporte'],data['Html'][i]['Valor'],data['Html'][i]['QtdHora'],
				data['Html'][i]['Status'], data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaTaxa.draw();
    }, "json");

}

//limpa os campos
function limpacampos() {
		$(".TextArea").val("");
		$(":text").val("");
		$(":password").val("");

}

//retorna na pagina anterior
function retornarpagina() {
	window.history.go(-1);
}

//função para cadastrar Taxa
function SalvaTaxa() {

	$('#FrmSalvarTaxas').ajaxForm({
		url : '../model/Taxa.php',
		data : {
			acao : 'Salva_Taxa'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#IncluirTaxas').modal('hide');
				BuscaTaxaTabela();
			}
			$('.msg').html(data['Html']);
		}
	});
}

function Saldo(){

	$.post("../model/Ticket.php", {
		acao : 'Saldo'
        
	}, function(data) {
		$("#Saldo").html(data['Saldo']);				
			
	}, "json");

}

//função para Alterar Taxa
function AlteraTaxa() {

	$('#FrmAlterarTaxa').ajaxForm({
		url : '../model/Taxa.php',
		data : {
			acao : 'Altera_Taxa'
		},
		dataType : 'json',
		success : function(data) {
			$('.msg').empty();
			if (data['Cod_Error'] == 0) {
				limpacampos();
				$('#AlterarTaxas').modal('hide');
				BuscaTaxaTabela();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ExcluirTaxa(Cod_Taxa){

	$.post("../model/Taxa.php", {
		acao : 'Exclui_Taxa',
        Cod_Taxa : Cod_Taxa
	}, function(data) {
			if(data['Cod_error']==0){
				BuscaTaxaTabela();
			}
	}, "json");

}


//busca as Tipoveiculo combobox
function ComboBox_TipoVeiculo() {

    $.post('../model/TipoVeiculos.php', {
        acao : 'Combobox_TipoVeiculo'
    }, function(data) {
        $('.TipoVeiculo').html(data['Html']);
    }, "json");

}