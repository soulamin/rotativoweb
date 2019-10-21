<?php
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';
function EnviaEmail($Rnome,$Remail,$RLogin,$RSenha){

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
    
    $Nome          = $Rnome;
    $Login = $RLogin ;
    $assunto   = 'Rotativo Digital Queimados';
    $Email =  $Remail;
    $NovaSenha = $RSenha;
    $mailer->Host = 'mail.okleiloes.com.br'; // Servidor smtp
    //Para cPanel: 'mail.dominio.com.br' ou 'localhost';
    //Para Plesk 7 / 8 : 'smtp.dominio.com.br';
    //Para Plesk 11 / 12.5: 'smtp.dominio.com.br' ou host do servidor exemplo : 'pleskXXXX.hospedagemdesites.ws';
    
    $mailer->SMTPAuth = true;                                   // Habilita a autenticação do form
    $mailer->IsSMTP();
    $mailer->isHTML(true);                                      // Formato de email HTML
    $mailer->Port = 587;									    // Porta de conexão
    
    $mailer->Username = 'suporte@brtecsistemas.com.br';                  // Conta de e-mail que realizará o envio
    $mailer->Password = '9sH0v^WDkUaXLj';                                   // Senha da conta de e-mail
    // email do destinatario
    $address = $Email ;
    $mailer->CharSet="UTF-8";
    //$mailer->SMTPDebug = 1;
	$corpoMSG = '  <span align="center">
	                        <img src="https://rotativo.brtecsistemas.com.br/figuras/logo.png">
	                </span>
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
							<tbody>                                 
									<td style="text-align:left">
										<p><h2>Caro <strong>'.$Nome.' ,</strong><br />
										<h3>Segue abaixo seu usuário e senha temporário para acessar sua conta.</h3>
										</p>
										

										<p><h3>Usuário : <strong> '.$Login.'</strong></p>

										<p><h3>Senha : <strong>'.$NovaSenha.'</strong></p>

										<p style="color : red;font-size: 18px; "> *Após entrar no sistema, não esqueça de Alterar sua Senha.</p>
								    </td>
							</tbody>
		            	</table>';
			
    $mailer->AddAddress($Email);        // email do destinatario
    $mailer->From = 'suporte@brtecsistemas.com.br';             //Obrigatório ser a mesma caixa postal indicada em "username"
    $mailer->Sender = 'suporte@brtecsistemas.com.br';
    $mailer->FromName = "Rotativo Queimados Digital";          // seu nome
    $mailer->Subject = $assunto;             // assunto da mensagem
    $mailer->MsgHTML($corpoMSG);             // corpo da mensagem
    //$mailer->AddAttachment($arquivo['tmp_name'], $arquivo['name']  );      // anexar arquivo   -   "caso não queira essa opção basta comentar"
    
    if(!$mailer->Send()) {
       //echo "Erro: " . $mailer->ErrorInfo; 
       return 1;
      } else {
        return 0 ;
       }
}
?>

