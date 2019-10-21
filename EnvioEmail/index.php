<!DOCTYPE html>
<html lang="pt-br">
<head><meta http-equiv="Content-Type" content="text/html; charset=ibm866">
    
    <title>Enviar e-mail</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="?acao=enviar" enctype="multipart/form-data">
   <table width="500" border="0" align="center" cellpadding="0" cellspacing="2">
   <tr>
     <td align="right">Nome:</td>
     <td><input type="text" name="nome" id="nome" /></td>
   </tr>
     <tr>
     <td align="right">Telefone:</td>
     <td><input type="text" name="telefone" id="telefone" /></td>
   </tr>
   <tr>
     <td align="right">Assunto:</td>
     <td><input type="text" name="assunto" id="assunto" /></td>
   </tr>
   <tr>
     <td align="right">Mensagem:</td>
     <td><textarea name="mensagem" id="mensagem" cols="45" rows="5"></textarea></td>
   </tr>
     <tr>
     <td colspan="4" align="center"><input type="submit" value="Enviar" /></td>
   </tr>
   </table>
</form>





<?php
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';

$mailer = new PHPMailer;

//$mailer->SMTPDebug = 2;                               

$mailer->isSMTP();                                      // funcao mailer para usar SMTP

$mailer->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);


if($_GET['acao'] == 'enviar'){
$nome          = $_POST['nome'];
$assunto   = $_POST['assunto'];
$mensagem  = $_POST['mensagem'];
$arquivo   = $_FILES["arquivo"];


$mailer->Host = 'iuri0134.hospedagemdesites.ws'; // Servidor smtp
//Para cPanel: 'mail.dominio.com.br' ou 'localhost';
//Para Plesk 7 / 8 : 'smtp.dominio.com.br';
//Para Plesk 11 / 12.5: 'smtp.dominio.com.br' ou host do servidor exemplo : 'pleskXXXX.hospedagemdesites.ws';

$mailer->SMTPAuth = true;                                   // Habilita a autenticação do form
$mailer->IsSMTP();
$mailer->isHTML(true);                                      // Formato de email HTML
$mailer->Port = 587;									    // Porta de conexão

$mailer->Username = 'contato@magusalgados.com.br';                  // Conta de e-mail que realizará o envio
$mailer->Password = 'gu2017buffeT';                                   // Senha da conta de e-mail
// email do destinatario
$address = "contato@magusalgados.com.br";

//$mailer->SMTPDebug = 1;
$corpoMSG = "<strong>Nome:</strong> $nome<br> <strong>Mensagem:</strong> $mensagem";

$mailer->AddAddress($address, "revendalw");        // email do destinatario
$mailer->From = 'contato@magusalgados.com.br';             //Obrigatório ser a mesma caixa postal indicada em "username"
$mailer->Sender = 'contato@magusalgados.com.br';
$mailer->FromName = "Formulário Contato Magu";          // seu nome
$mailer->Subject = $assunto;             // assunto da mensagem
$mailer->MsgHTML($corpoMSG);             // corpo da mensagem
$mailer->AddAttachment($arquivo['tmp_name'], $arquivo['name']  );      // anexar arquivo   -   "caso não queira essa opção basta comentar"

if(!$mailer->Send()) {
   echo "Erro: " . $mailer->ErrorInfo; 
  } else {
   echo "Mensagem enviada com sucesso!";
  }
}


?>

