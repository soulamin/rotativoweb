<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 25/10/2017
 * Time: 15:26
 */
require '../fontes/conexao.php';
session_start();
$acao = $_POST['acao'];

switch($acao){



    case 'Alterar_Pagamento' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo       = $_POST['Txt_Codigo'];
        $TipoPG       = $_POST['ATipoPg'];
        $ValorTotal   = str_replace(",",".",str_replace(".","",$_POST['ATxt_ValorTotal']));


        if(!empty($ValorTotal)){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE grv_pagamento SET VALORTOTAL=:valortotal,TipoPG=:tipopg WHERE IDPAGAMENTO=:id');

            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':valortotal',  $ValorTotal);
            $statement->bindParam(':tipopg',  $TipoPG);
            $statement->bindParam(':id',  $Codigo);

            // Executa a senten�a j� com os valores
            if($statement->execute()){
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
		                       <h4><i class='icon fa fa-check'></i>
		                            Cadastro Realizado com Sucesso !</h4></div>";

            }else{
                $Cod_Error = '1';
                $Html = "<div class='alert alert-warning disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Dados já cadastrado! </h4>
	                       </div>";
            }


        }else{

            $Cod_Error = '1';
            $Html = "<div class='alert alert-danger disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Existe(m) Campo(s) Vazio(s). Por favor preencher!</h4>
	                       </div>";
        }

        $resultado['Cod_Error'] = $Cod_Error;
        $resultado['Html'] = $Html;
        echo json_encode($resultado);

        break;


    case 'Busca_Pagamento_Tabela' :

        $IdPatio = $_SESSION['IDPATIO'];

        if( $_SESSION['NIVEL']=='A'|| $_SESSION['NIVEL']=='S') {
            $stmt = $pdo->prepare('SELECT * FROM grv_pagamento WHERE IDPATIO LIKE :idpatio');
            $stmt->bindParam(':idpatio',  $IdPatio);
            $stmt->execute();
            $Pagamento = array();

            while ($linha = $stmt->fetch()) {
                if ($linha['TIPOPG'] == 'C') {
                    $TipoPG = '<span class="label label-info">CARTÃO</span>';
                } elseif ($linha['TIPOPG'] == 'D') {
                    $TipoPG = '<span class="label label-info">DINHEIRO</span>';
                } else {
                    $TipoPG = '<span class="label label-info">BOLETO/TED</span>';
                }

                $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDPAGAMENTO'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";

                $p = array('GRV' => $linha['GRV'], 'TipoPg' => $TipoPG, 'ValorTotal' => number_format($linha['VALORTOTAL'], 2, ",", ""), 'Html_Acao' => $botaoEdit);
                array_push($Pagamento, $p);

            }

            $Resultado['Html'] = $Pagamento;
            echo json_encode($Resultado);
        }else{
            session_destroy();
        }
    break ;


    case 'Busca_Pagamento_Formulario' :

        if($_SESSION['NIVEL']=='A' || $_SESSION['NIVEL']=='S') {

            $CodPagamento = $_POST['Cod_Pagamento'];
            $stmt = $pdo->prepare('SELECT * FROM grv_pagamento  WHERE IDPAGAMENTO= :codpagamento');
            $stmt->bindParam(':codpagamento', $CodPagamento);
            $stmt->execute();
            while ($linha = $stmt->fetch()) {
                $c = array('TipoPg' => $linha['TIPOPG'], 'ValorTotal' => number_format($linha['VALORTOTAL'], 2, ",", ""));
            }
            $Resultado['Html'] = $c;
            echo json_encode($Resultado);
        }else{
            session_destroy();
        }
        break ;



}