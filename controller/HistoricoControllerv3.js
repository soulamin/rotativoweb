/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/

tabelaBuscaHistorico=null;
$(".Celular").inputmask({
    mask : ["(99)9999-9999", "(99)99999-9999"],
    keepStatic : true
});
$(".Placa").inputmask({
	mask : ["AAA9999", "AAA9A99"],
	keepStatic : true
});
$(".Val").inputmask("99/9999");
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
	instanciaTabelaBusca();
	BuscaHistoricoTabela();
	BotaoRecarga();
});


//Botão para Com Valores
$(document).off("click", ".BotaoRecarga");
$(document).on("click", ".BotaoRecarga", function() {
    SelecionarBotao($(this).attr('codigo'),$(this).attr('valor'));
});


//Botão para  Liberar Vaga
$(document).off("click", "#btnRenovaTicket");
$(document).on("click", "#btnRenovaTicket", function() {
    BuscaTicketInfo($(this).attr('codigo'));
   
});

//Botão para  Recarga
$(document).off("click", "#btnRecargaPg");
$(document).on("click", "#btnRecargaPg", function() {
    PagamentosRecarga();
   
});

//Botão para  Liberar Vaga
$(document).off("click", ".btnLiberarVaga");
$(document).on("click", ".btnLiberarVaga", function() {
   $('#ConfirmaLiberacao').modal('show');
  $('#btnRenovaTicket').attr("codigo",$(this).attr('codigo'));
   LiberarVaga($(this).attr('codigo'));

});

//Busca Tabela status
$(document).off("click", ".btnInfoTicket");
$(document).on("click", ".btnInfoTicket", function() {
    InfoTicket($(this).attr('codigo'));
});

//busca  cadastrada  para a combobox
function BuscaTicket() {
    $.post('../model/Ticket.php', {
        acao : 'Busca_Ticket',
    }, function(data) {
        $('.GerenciaTickets').html(data['Html']);
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

    if (tabelaBuscaHistorico != null) {
		tabelaBuscaHistorico.destroy();
		tabelaBuscaHistorico = null;
    } else {
		tabelaBuscaHistorico = $('#TabelaHistorico').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
            },
            "processing": true,
			"autoFill": true,
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

function BuscaHistoricoTabela() {
	$.post("../model/Ticket.php", {
		acao : 'Busca_Historico_Tabela',
		
	},function(data) {
		$("#Saldo").html(data['Saldo']);
		tabelaBuscaHistorico.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaHistorico.row.add([data['Html'][i]['Placa'],data['Html'][i]['DataHora'],data['Html'][i]['Status']]);
        }
		tabelaBuscaHistorico.draw();
    }, "json");


}
function BuscaTicketInfo(CodTicket) {

    $.post("../model/Ticket.php", {
        acao : 'Renova_Ticket',
        Cod_Id : CodTicket
    }, function(data) {
        ComboBox_TipoVeiculo();
        $('#ConfirmaLiberacao').modal('hide');
        $('#IncluirTicket').modal("show");
        $('#Txt_Placa').val(data['Html']['Placa']);
        DataHoraAtual();
        BotaoTaxa(data['Html']['IdTrans']);
        $('#Txt_TipoVeiculo').val(data['Html']['IdTrans']);
        $('#Txt_LocalFiscal').val(data['Html']['IDLOCALFISCAL']);
       // $('#Txt_Fiscal').html(data['Html'][0]['Fiscal']);
       // BuscaPlaca(data['Html']['Placa']);
        timestamp();
       
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

function LiberarVaga(Cod_Ticket){

	$.post("../model/Ticket.php", {
		acao : 'Libera_Vaga',
        Ticket : Cod_Ticket
	}, function(data) {
		if(data['Cod_Error']==0){
            BuscaTicket();
           // $('.PesquisaPlaca').empty();
		}
	}, "json");

}





//Salva Pagamento
function PagamentosRecarga() {

    $.post('../model/Usuarios.php', {
        acao        : 'Pagamentos',
		Txt_Cartao  : $('#Txt_Cartao').val(),
		Txt_Recarga : $('#Txt_Recarga').val()
    }, function(data) {
        if (data['Cod_Error']==0) {
			window.alert('Pagamento Realizado com Sucesso!');
            location.reload();
        }else if (data['Cod_Error']==1) {
            window.alert('Pagamento Negado!');
        }else{
			window.alert('Preeencher os dados do cartao!');
		}

    }, "json");

}


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

//Libera Veiculo do Pre Liberacao
function InfoTicket(codigo) {

    $.post('../model/Ticket.php', {
        acao   : 'Busca_InfoTicket',
        Cod_Id    : codigo
       
    }, function(data) {
		$('#Txt_Ticket').html(data['Html']['Ticket']);
		$('#Txt_Valor').html(data['Html']['Valor']);
		$('#Txt_Placa').html(data['Html']['Placa']);
		$('#Txt_Fiscal').html(data['Html']['Fiscal']);
		$('#Txt_DataHoraSaida').html(data['Html']['DataHoraSaida']);
		$('#Txt_DataHoraEntrada').html(data['Html']['DataHoraEnt']);
		$('#Txt_Localidade').html(data['Html']['Localidade']);
       $("#TicketInfo").modal('show');
    }, "json");

}

//Excluir GRV
function ExcluirGrv(grv,patio) {

    $.post('../model/StatusVeiculo.php', {
        acao   : 'Exclui_Grv',
        Grv    : grv,
        Patio  : patio
    }, function(data) {
        if (data['Cod_Error']==1) {
            alert("GRV EXCLUÍDA COM SUCESSO!");
        }

    }, "json");

}


//Excluir Lacre
function ExcluirGrvLacre(idlacre){

	$.post("../model/GrvLacre.php", {
		acao : 'Exclui_GrvLacre',
		IdLacre: idlacre
	}, function(data) {
		if(data['Cod_error']==0){
			TabelaLacre($('.GRV').val(),$('.Patio').val());
		}
	}, "json");

}

//Tabela checklist
function TabelaChecklist(grv,patio) {

	$.post('../model/GrvChecklist.php', {
		acao   : 'Tabela_GrvChecklist',
		Grv    : grv,
		Patio  : patio
	}, function(data) {
		$('#conteudochecklist').html(data['Html']);

	}, "json");

}

//Tabela Infracao
function TabelaInfracao(grv,patio) {

	$.post('../model/Grv.php', {
		acao   : 'Busca_GrvInfracao_Tabela',
		Grv    : grv,
		Patio  : patio
	}, function(data) {
		$('#conteudoinfracao').html(data['Html']);

	}, "json");

}

//Salva Infracao
function AtualizaPerfil() {

	$.post('../model/Usuarios.php', {
		acao   : 'AtualizaPerfil',
		
	}, function(data) {
		if (data['Cod_error']==0) {
			$("#NumeroInfracao").val("");
			TabelaInfracao($('.GRV').val(),$('.Patio').val());
		}else{
			window.alert('Número da Infração já utilizado !');
		}

	}, "json");

}



//Salva CheckList
function SalvaChecklist(estequip,equipamento,obs,grv,patio) {

	$.post('../model/GrvChecklist.php', {
		acao   : 'Salva_GrvChecklist',
		Estado : estequip,
		Equipamento  : equipamento,
		Obs: obs,
		Grv    : grv,
		Patio  : patio
	}, function(data) {
		if (data['Cod_error']==0) {
			$("#Obs").val("");
			TabelaChecklist($('.GRV').val(),$('.Patio').val());
		}else{
			window.alert('Número da Infração já utilizado !');
		}

	}, "json");

}



//busca  cadastrada  para a combobox
function ComboboxEmpresas() {

	$.post('../model/Empresas.php', {
		acao : 'Combobox_Empresas'
	}, function(data) {
		$('.Empresas').html(data['Html']);

	}, "json");

}

//busca  cadastrada  para a combobox
function ComboboxPatio() {

	$.post('../model/Patios.php', {
		acao : 'Select_Patio'
	}, function(data) {
		$('.Patio').html(data['Html']);

	}, "json");

}

//busca Equipamentos cadastrada  para a combobox
function ComboboxEquipamento() {
	$.post('../model/Equipamentos.php', {
		acao : 'Combobox_Equipamento'
	}, function(data) {
		//$('#Equipamento').select2();
		$('#Equipamento').html(data['Html']);

	}, "json");

}



//busca as Motivos cadastrada  para a combobox
function ComboboxMotivo() {

	$.post('../model/Motivos.php', {
		acao : 'Combobox_Motivo'
	}, function(data) {
		//$('#Motivo').select2();
		$('#Motivo').html(data['Html']);

	}, "json");

}

//busca as infracao cadastrada  para a combobox
function ComboboxInfracao() {

	$.post('../model/Infracao.php', {
		acao : 'Combobox_Infracao'
	}, function(data) {
		$('.Infracao').select2();
		$('.Infracao').html(data['Html']);

	}, "json");

}

//busca as Acadastrada  para a combobox
function ComboboxAgente() {
	$.post('../model/LocalFiscal.php', {
		acao : 'Combobox_AgenteFiscalizador'
	}, function(data) {
		//$('#Agente').select2();
		$('#Agente').html(data['Html']);

	}, "json");

}

//busca as Empresas cadastrada  para a combobox
function ComboboxReboque() {
	$.post('../model/TipoArea.php', {
		acao : 'Combobox_Reboque'
	}, function(data) {
		//$('#Reboque').select2();
		$('#Reboque').html(data['Html']);

	}, "json");

}

//busca as Empresas cadastrada  para a combobox
function ComboboxReboquista() {
	$.post('../model/Reboquistas.php', {
		acao : 'Combobox_Reboquista'
	}, function(data) {
		//$('#Reboquista').select2();
		$('#Reboquista').html(data['Html']);
	}, "json");

}

//Tabela checklist
function TabelaChecklist(grv,patio) {

	$.post('../model/GrvChecklist.php', {
		acao   : 'Tabela_GrvChecklist',
		Grv    : grv,
		Patio  : patio
	}, function(data) {
		$('#conteudochecklist').html(data['Html']);

	}, "json");

}


//Tabela Lacre
function TabelaLacre(grv,patio) {

	$.post('../model/GrvLacre.php', {
		acao   : 'Busca_GrvLacre_Tabela',
		Grv    : grv,
		Patio  : patio
	}, function(data) {
		$('#TabelaLacres').html(data['Html']);
	}, "json");

}

//busca as Tipo Veiculo
function ComboboxTipoVeiculo() {

    $.post('../model/TipoVeiculos.php', {
        acao : 'Combobox_TipoVeiculo'
    }, function(data) {
        //$('.TipoVeiculo').select2();
        $('.TipoVeiculo').html(data['Html']);

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



