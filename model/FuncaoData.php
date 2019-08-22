<?php

    function PdBrasil($dtcadastro){

        $data = explode("-", $dtcadastro);
        $data = array_reverse($data);
        $dtcadastro = implode("/", $data);

        return $dtcadastro;
    }

    function PdBd($dtcadastro){

        $data = explode("/", $dtcadastro);
        $data = array_reverse($data);
        $dtcadastro = implode("-", $data);

        return $dtcadastro;
    }


	function ParametroQuant(){

        require '../fontes/conexao.php';

        $DataInicio = date('Y-m-01');
        $DataFim    = date('Y-m-31');

        // Prepara uma senten�a para ser executada
        $slimite = $pdo->prepare('SELECT  QTDPERMITIDO  FROM empresa limit 1');
        $slimite->execute();
        $limite =$slimite->fetch();

        // Prepara uma senten�a para ser executada
        $sqtdMes = $pdo->prepare('SELECT COUNT(GRV) AS QTDPATIO FROM grv_status WHERE DATAREMOCAO BETWEEN  :datainicio AND :datafim');
        $sqtdMes->bindParam(':datainicio', $DataInicio);
        $sqtdMes->bindParam(':datafim', $DataFim);
        $sqtdMes->execute();
        $QtdMes =$sqtdMes->fetch();
         //caso a QTD PERMITIDO ESTEJA 0 A regra Nao funciona
        if($limite['QTDPERMITIDO']==0){
            $proprietario=1;
        }else{
                if ($limite['QTDPERMITIDO']> $QtdMes['QTDPATIO']) {
                    $proprietario= 1;
                } else {
                    $proprietario = 2;
                }
        }

        return $proprietario;
	}

	function diasemana($data) {
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);

	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

	switch($diasemana) {
		case"0": $diasemana = "DOMINGO";       break;
		case"1": $diasemana = "SEGUNDA-FEIRA"; break;
		case"2": $diasemana = "TERÇA-FEIRA";   break;
		case"3": $diasemana = "QUARTA-FEIRA";  break;
		case"4": $diasemana = "QUINTA-FEIRA";  break;
		case"5": $diasemana = "SEXTA-FEIRA";   break;
		case"6": $diasemana = "SÁBADO";        break;
	}

	echo "$diasemana";
}

?>


