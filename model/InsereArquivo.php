<?php

function InserirArquivo($PastaCompl,$nomeArquivo,$tempArquivo,$tamanhoArquivo,$extensao){

$Pasta = 'Arquivos/'.$PastaCompl.'/';
$ArqPermitidos = array('.png','.jpeg','.jpg','.bmp');
$TipoExtensao = $extensao;
$tamanhoPermitido = 30000*30000 ;


   if (($TipoExtensao=='image/jpeg')|| ($TipoExtensao=='image/jpg')||($TipoExtensao=='image/png')||($TipoExtensao=='image/bmp')){

       date_default_timezone_set('America/Sao_Paulo');
       $ext =str_replace("image/", ".", $TipoExtensao);
       $nomedoarquivo =$Pasta.$_SESSION['ID_USUARIO'].rand(0,9).substr($nomeArquivo,0,3).time().$ext;
       move_uploaded_file($tempArquivo,'../'.$nomedoarquivo);
       return  $nomedoarquivo;

   }elseif ($tamanhoArquivo > $tamanhoPermitido) {

            return FALSE;

    }else {
       return FALSE ;

    }

}

function InserirArquivoExtensao($PastaCompl,$nomeArquivo,$tempArquivo,$tamanhoArquivo,$ExtensaoPermitida){

    $Pasta = 'arquivos/'.$PastaCompl.'/';

    if($ExtensaoPermitida==1){
        $ArqPermitidos = array('.doc', '.xls','.docx', '.xlsx','.jpg','.pdf','.zip','.rar');
    }elseif($ExtensaoPermitida==33){
        $ArqPermitidos = array('.doc', '.docx', '.xls','.xlsx','.zip','.rar');
    }elseif($ExtensaoPermitida==32){
        $ArqPermitidos = array('.doc','.docx','.pdf','.zip','.rar');
    }elseif($ExtensaoPermitida==34){
        $ArqPermitidos = array('.doc','.docx','.pdf','.jpg','.png','.zip','.rar');
    }elseif($ExtensaoPermitida==35){
        $ArqPermitidos = array('.doc','.docx','.pdf','.xls','.xlsx','.zip','.rar');
    }else{
        $ArqPermitidos = array('.jpg','.png','.jpeg');
    }

    $extensao = strchr($nomeArquivo,'.');
    $tamanhoPermitido = 1024*500000 ;


    if (array_search($extensao,$ArqPermitidos) === false){

        return FALSE ;

    }elseif ($tamanhoArquivo > $tamanhoPermitido) {

        return FALSE;

    }else {
        date_default_timezone_set('America/Sao_Paulo');
        $nomedoarquivo =$Pasta.time().$extensao;
        move_uploaded_file($tempArquivo,'../'.$nomedoarquivo);
        return  $nomedoarquivo;
    }

}
