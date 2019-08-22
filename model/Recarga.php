<?php

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

require 'vendor/autoload.php';

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;

use Cielo\API30\Ecommerce\Request\CieloRequestException;

require '../fontes/conexao.php';

$acao = $_POST['acao'];

switch($acao){

   
    case 'Recarga' :

        //Variaveis
        session_start();
        $CodCompra        =  $_SESSION['ID_USUARIO'].time();
        $NomeCartao       = $_POST['Txt_NomeCartao'];
        $NumeroCartao     = $_POST['Txt_Cartao'];
        $ValidadeCartao   = $_POST['Txt_Validade'];
        $CodCartao        = $_POST['Txt_Cod'];
        $Recarga          = $_POST['Txt_Recarga'];

    
            
            if($_POST['Txt_Cartao'][0]=='2'){
                $Bandeira         = 'Master Card';
            }elseif($_POST['Txt_Cartao'][0]=='4'){
                $Bandeira         = 'Visa';
            }elseif($_POST['Txt_Cartao'][0]=='3'){
                $Bandeira         = 'American Express';
            }elseif($_POST['Txt_Cartao'][0]=='5'){
                $Bandeira         = 'Master Card';
            }else{
                $Bandeira         = 'Discover';
            }
                        // Configure o ambiente
                $environment = $environment = Environment::sandbox();

                // Configure seu merchant
                $merchant = new Merchant('991598c7-f401-487c-8104-5c3466fab74c', 'TNEXQENOMIOQDYMTXMWPVJERZATAXKAXYJYGRUEQ');

                // Crie uma instância de Sale informando o ID do pedido na loja
                $sale = new Sale($CodCompra);

                // Crie uma instância de Customer informando o nome do cliente
                $customer = $sale->customer($NomeCartao);

                // Crie uma instância de Payment informando o valor do pagamento
                $payment = $sale->payment((int) str_replace(".", "", $Recarga));

                $payment->setCapture(1);

                // Crie uma instância de Credit Card utilizando os dados de teste
                // esses dados estão disponíveis no manual de integração
                $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
                        ->creditCard($CodCartao , $Bandeira)
                        ->setExpirationDate($ValidadeCartao)
                        ->setCardNumber($NumeroCartao)  
                        ->setHolder( $NomeCartao);

                // Crie o pagamento na Cielo
                try {
                    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
                    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

                    // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
                    // dados retornados pela Cielo
                    $paymentId = $sale->getPayment()->getPaymentId();

                  //  echo $sale->getPayment()->getStatus();
                  //  echo "-";
                  $CodRetorno= $sale->getPayment()->getReturnCode();
                  //  echo "<pre>";
                 //   print_r($sale->getPayment());
                 $Resumo =  $sale->getPayment()->getTid();
                    
                    if($sale->getPayment()->getStatus() == 2){

                        $stmt = $pdo->prepare( 'UPDATE usuarios SET SALDO = SALDO + :recarga WHERE IDUSUARIO =:usuario');
                        $stmt ->bindParam( ':usuario', $_SESSION['ID_USUARIO']);
                        $stmt ->bindParam( ':recarga', $Recarga);
                        $executa=$stmt->execute();
                        $Cod_Error = 0;
                        //Header("Location: retorno.php?cod=0&TID=" . $sale->getPayment()->getTid());
                    }else{
                        $Cod_Error = 1;
                      //  Header("Location: retorno.php?cod=1&status=".$sale->getPayment()->getStatus()."&erro=".$sale->getPayment()->getReturnCode());
                    }
                    
                    // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
                    //$sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, 15700, 0);

                    // E também podemos fazer seu cancelamento, se for o caso
                    //$sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, 15700);
                } catch (CieloRequestException $e) {
                    // Em caso de erros de integração, podemos tratar o erro aqui.
                    // os códigos de erro estão todos disponíveis no manual de integração.
                    //print_r($e->getCieloError());
                    //$erro = $e->getCieloError()->getMessage() . "-" . $e->getCieloError()->getCode();
                    //echo $erro; die();
                    //echo $e->getCieloError()->code . $e->getCieloError()->message;
                    ///Header("Location: retorno.php?cod=2&erro=" . $e->getCieloError()->getCode());
                    $Cod_Error = 5;
                }
                
                $st = $pdo->prepare('INSERT INTO pagamento (IDPAG,VALOR,ID_USUARIO,RESUMO,CODIGORETORNO) VALUES (:idCompra,:valor,:idusuario ,:resumo,:codigoretorno)');
                $st->bindParam(':idusuario', $_SESSION['ID_USUARIO']);
                $st->bindParam(':idCompra', $CodCompra);
                $st->bindParam(':valor', $Recarga);
                $st->bindParam(':resumo', $Resumo);
                $st->bindParam(':codigoretorno', $CodRetorno);
                $st->execute();

     
                        $Resultado['Cod_Error']=$Cod_Error;
                        echo json_encode($Resultado);
                        break;
}


