<?php


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
        $NumeroCartao     =  str_replace(".", "", $_POST['Txt_Cartao']);;
        $ValidadeCartao   = $_POST['Txt_Validade'];
        $CodCartao        = $_POST['Txt_Cod'];
        $Recarga          = $_POST['Txt_Recarga'];

                if(($_POST['Txt_Cartao'][0]=='2') || ($_POST['Txt_Cartao'][0]=='5') ){
                    $Bandeira         = 'Master';
                }elseif($_POST['Txt_Cartao'][0]=='4'){
                    $Bandeira         = 'Visa';
                }elseif($_POST['Txt_Cartao'][0]=='3'){
                    $Bandeira         = 'Amex';
                }else{
                    $Bandeira         = 'Discover';
                }
                        // Configure o ambiente
               // $environment = $environment = Environment::sandbox();
               $environment = $environment = Environment::production();
               //$environment = null;

                // Configure seu merchant
                // API TESTE
               // $merchant = new Merchant('991598c7-f401-487c-8104-5c3466fab74c', 'TNEXQENOMIOQDYMTXMWPVJERZATAXKAXYJYGRUEQ');

                //area de Desenvolvimento
               $merchant = new Merchant('2810386c-1d91-494d-8f62-25ca91f35897','QeasyVg6Id0dJcR03ehxf5FgCW1JevpIKr3k4yIz');

                // Crie uma instância de Sale informando o ID do pedido na loja
                $sale = new Sale($CodCompra);

                // Crie uma instância de Customer informando o nome do cliente
                $customer = $sale->customer($NomeCartao);

                // Crie uma instância de Payment informando o valor do pagamento
                $payment = $sale->payment((int) str_replace(".", "", $Recarga));

                $payment->setCapture(true);

                // Crie uma instância de Credit Card utilizando os dados de teste
                // esses dados estão disponíveis no manual de integração
                $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
                        ->creditCard($CodCartao ,  $Bandeira)
                        ->setExpirationDate($ValidadeCartao)
                        ->setCardNumber($NumeroCartao)  
                        ->setHolder($NomeCartao)
                        ->setSaveCard(true);

                // Crie o pagamento na Cielo
                try {
                    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
                    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

                    // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
                    // dados retornados pela Cielo
                    $paymentId = $sale->getPayment()->getPaymentId();
                    $Resumo=$sale->getPayment()->getReturnMessage();
                    $CodRetorno= $sale->getPayment()->getReturnCode();
                    $Token = $sale->getPayment()->getCreditCard()->getCardToken();
                  
                      
                    
                    if($CodRetorno == 00 ){
                        $Status =1;
                         $NCartao = substr($NumeroCartao,-4);
                        $sttoken = $pdo->prepare('INSERT INTO token (TOKEN,ID_USUARIO,STATUS,CARTAO,VAL,TIPO) 
                        VALUES (:token,:id_usuario,:status,:cartao,:val,:tipo)');
                            $sttoken->bindParam(':id_usuario', $_SESSION['ID_USUARIO']);
                            $sttoken->bindParam(':token', $Token);
                            $sttoken->bindParam(':status', $Status);
                            $sttoken->bindParam(':val', $ValidadeCartao);
                            $sttoken->bindParam(':cartao', $NCartao);
                            $sttoken->bindParam(':tipo', $Bandeira);

                            $sttoken->execute();

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
                    $st = $pdo->prepare('INSERT INTO pagamento (IDPAG,VALOR,ID_USUARIO,RESUMO,CODIGORETORNO) VALUES (:idCompra,:valor,:idusuario ,:resumo,:codigoretorno)');
                    $st->bindParam(':idusuario', $_SESSION['ID_USUARIO']);
                    $st->bindParam(':idCompra', $CodCompra);
                    $st->bindParam(':valor', $Recarga);
                    $st->bindParam(':resumo', $Resumo);
                    $st->bindParam(':codigoretorno', $CodRetorno);
                    $st->execute();
                    // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
                    //$sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, 15700, 0);

                    // E também podemos fazer seu cancelamento, se for o caso
                    //$sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, 15700);
                } catch (CieloRequestException $e) {
                    // Em caso de erros de integração, podemos tratar o erro aqui.
                    // os códigos de erro estão todos disponíveis no manual de integração.
               // print_r($e->getCieloError());
             //   $erro = $e->getCieloError()->getMessage() . "-" . $e->getCieloError()->getCode();
             //    $erro; die();
             //    echo $e->getCieloError()->code . $e->getCieloError()->message;
            //       // Header("Location: retorno.php?cod=2&erro=" . $e->getCieloError()->getCode());
             //    $error = $e->getCieloError();
                    $Cod_Error = 5;
                }
                
                        $Resultado['Cod_Error']=$Cod_Error;
                        echo json_encode($Resultado);
                        break;

        case 'RecargaToken' :

                        //Variaveis
                        session_start();
                        $CodCompra        =  $_SESSION['ID_USUARIO'].time();
                        $Token            = $_POST['Txt_Token'];
                        $CodCartao        = $_POST['Txt_Cod'];
                        $Recarga          = $_POST['Txt_Recarga'];
                
                           
                        $stmtslt = $pdo->prepare('SELECT * FROM token  WHERE IDTOKEN= :codtoken');
                        $stmtslt->bindParam(':codtoken', $Token);
                        $stmtslt->execute();
                        $linhatoken = $stmtslt->fetch();

                       $Bandeira = $linhatoken['TIPO'];
                       $CodToken = $linhatoken['TOKEN'];

                                 // $environment = $environment = Environment::sandbox();
                                    $environment = $environment = Environment::production();
                                    //$environment = null;

                                        // Configure seu merchant
                                        // API TESTE
                                    // $merchant = new Merchant('991598c7-f401-487c-8104-5c3466fab74c', 'TNEXQENOMIOQDYMTXMWPVJERZATAXKAXYJYGRUEQ');

                                        //area de Desenvolvimento
                                    $merchant = new Merchant('2810386c-1d91-494d-8f62-25ca91f35897','QeasyVg6Id0dJcR03ehxf5FgCW1JevpIKr3k4yIz');
                
                                // Crie uma instância de Sale informando o ID do pedido na loja
                                $sale = new Sale($CodCompra);
                
                                // Crie uma instância de Customer informando o nome do cliente
                                $customer = $sale->customer('siga sempre');
                
                                // Crie uma instância de Payment informando o valor do pagamento
                                $payment = $sale->payment((int) str_replace(".", "", $Recarga));
                                
                                // Crie uma instância de Credit Car utilizando os dados de teste
                                // esses dados estão disponíveis no manual de integração
                                $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
                                ->creditCard($CodCartao, $Bandeira)
                                ->setCardToken($CodToken);
                                // Crie o pagamento na Cielo
                                try {
                                    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
                                    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);
                
                                    // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
                                    // dados retornados pela Cielo
                                    $paymentId = $sale->getPayment()->getPaymentId();
                                    $Resumo=$sale->getPayment()->getReturnMessage();
                                    $CodRetorno= $sale->getPayment()->getReturnCode();
                                    $Token = $sale->getPayment()->getCreditCard()->getCardToken();

                                    if($CodRetorno == 00 ){
                                                                              
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
                                    $st = $pdo->prepare('INSERT INTO pagamento (IDPAG,VALOR,ID_USUARIO,RESUMO,CODIGORETORNO) VALUES (:idCompra,:valor,:idusuario ,:resumo,:codigoretorno)');
                                    $st->bindParam(':idusuario', $_SESSION['ID_USUARIO']);
                                    $st->bindParam(':idCompra', $CodCompra);
                                    $st->bindParam(':valor', $Recarga);
                                    $st->bindParam(':resumo', $Resumo);
                                    $st->bindParam(':codigoretorno', $CodRetorno);
                                    $st->execute();
                                    // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
                                    //$sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, 15700, 0);
                
                                    // E também podemos fazer seu cancelamento, se for o caso
                                    //$sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, 15700);
                                } catch (CieloRequestException $e) {
                                    // Em caso de erros de integração, podemos tratar o erro aqui.
                                    // os códigos de erro estão todos disponíveis no manual de integração.
                                    print_r($e->getCieloError());
                                     ///erro = $e->getCieloError()->getMessage() . "-" . $e->getCieloError()->getCode();
                                     $erro; die();
                                     echo $e->getCieloError()->code . $e->getCieloError()->message;
                            //       // Header("Location: retorno.php?cod=2&erro=" . $e->getCieloError()->getCode());
                               $error = $e->getCieloError();
                                    $Cod_Error = 5;
                                }
                                
                                        $Resultado['Cod_Error']=$Cod_Error;
                                        echo json_encode($Resultado);
                                        break;
                                           //Desativa o Veiculo Status
    case 'ExcluiToken' :

    $Cod_Token= $_POST['Cod_Token'];
    $stmt = $pdo->prepare( 'UPDATE token SET STATUS = 0  WHERE IDTOKEN= :Cod_Token');
    $stmt ->bindParam( ':Cod_Token', $Cod_Token );
    if($stmt->execute()){

        $Cod_Error = 0;
    }
    $Resultado['Cod_Error'] = $Cod_Error;
    echo json_encode($Resultado);

    break ;

}


