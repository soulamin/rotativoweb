<?php
if(!isset ($_SESSION["login"])){
    session_destroy();
?>
<script type='text/javascript'>

window.alert(' USUARIO SEM ACESSO!');window.location="/Brtec";</script>
<?php
}
else {
echo "<strong>" ; 
include 'classe/data_hora.php'; 
echo "</strong> <p align='right'>Seja  Bem Vindo , <strong>".$_SESSION['login']."</strong>. ";
?>
<a href="#" style="text-decoration:none;" onclick="javascript:void window.open('altera_senha.php','Altera senha','width=400,height=200,toolbar=1,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=10,top=10');return false;">(Alterar Senha) &nbsp;&nbsp;&nbsp;&nbsp; </a>
    <a style="text-decoration:none;" href="admin\sair.php"> <img src="imagens/sair.png" width="20" title="SAIR" height="21" />Sair&nbsp;&nbsp;</a></p>
<?php
   }
   
   
?>


