<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>COMUNICARTE :: Comunica&ccedil;&atilde;o e Gest&atilde;o Socioambiental</title>
<meta name="description" content="" />
<meta name="keywords" content="Comunicao e Marketing Empresarial, Sustentabilidade, Responsabilidade Social" />
	<meta name="author" content="SIGLADESIGN" />
	<meta name="robots" content="index, follow" />
	<meta name="googlebot" content="index, follow" />
	<meta name="revisit-after" content="5 days" />
<script src="scripts/jquery.js" type="text/javascript"></script>
<script src="scripts/jquery.tools.min.js"></script>
<script src="scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="scripts/funcoes.js" type="text/javascript"></script>

<!--Adobe Edge Runtime-->
<script type="text/javascript" charset="utf-8" src="edge_includes/edge.6.0.0.min.js"></script>
<style>
 .edgeLoad-banner_html5 { visibility:hidden; }
</style>
<!--<script>
   AdobeEdge.loadComposition('banners', 'banner_html5', {
    scaleToFit: "none",
    centerStage: "none",
    minW: "0px",
    maxW: "undefined",
    width: "964px",
    height: "306px"
}, {dom: [ ]}, {dom: [ ]});
</script>
<!--Adobe Edge Runtime End-->


<link rel="shortcut icon" type="image/x-icon" href="images/iconeComunicarte.ico">

<!-- carrossel -->

<!--
  jQuery library
-->

<!--
  jCarousel library
-->
<script type="text/javascript" src="jcarousel/lib/jquery.jcarousel.pack.js"></script>
<!--
  jCarousel core stylesheet
-->
<link rel="stylesheet" type="text/css" href="jcarousel/lib/jquery.jcarousel.css" />
<!--
  jCarousel skin stylesheet 
  para IE7
  <link rel="stylesheet" type="text/css" href="jcarousel/skins/ie7/skin.css" />
-->

<link rel="stylesheet" type="text/css" href="jcarousel/skins/tango/skin.css" />

<!--[if lte IE 7]>

<![endif]-->


<script type="text/javascript">

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        start: 1
    });
});

</script>
<link href="scripts/estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-7258837-6']);

  _gaq.push(['_trackPageview']);

 

  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();

</script>
</head>
<body>

<div id="container">
<div id="efeito">
</div>
<div id="geral">
<div id="quadradoTopo">
</div>
	<?php include"topoMenu.php"; ?>
    <!-- FIM DO TOPO -->
    
    <!-- SUBMENUS -->
    <div class="submenus" >
            <!-- panes -->
            <span class="description" id="quemsomos">
                <ul>
                    <li><a href="apresentacao.php?ativo=quemsomos" >Apresenta&ccedil;&atilde;o</a></li>
                    <li><a href="politica-de-gestao-integrada.php?ativo=quemsomos" >Pol&iacute;tica de Gest&atilde;o Integrada</a></li>
                    <li><a href="nossos-valores.php?ativo=quemsomos">Nossos Valores</a></li>
                    <li><a href="nossos-atributos.php?ativo=quemsomos">Nossos Atributos</a></li>
                    <li><a href="nossos-parceiros.php?ativo=quemsomos">Parceiros e Consultores</a></li>
                    <li class="fimMenu"><a href="contato.php?ativo=quemsomos">Contato</a></li>
                </ul>
            </span>
            
<span class="description" id="nossosprojetos">
			    <ul>
                
                    <li class="fimMenu"><a href="#">&nbsp;</a></li>
                </ul>
      </span>
            <!-- necessrio ter esta div com este contedo vazio por causa do chrome -->          
     		 <span class="description" id="nossosclientes">
			    <ul>
                
                    <li class="fimMenu"><a href="#">&nbsp;</a></li>
                </ul> </span>            

            <span class="description" id="conhecimento">
                <ul>
                    <li><a href="conceitos.php?ativo=conhecimento">Conceitos</a></li>
                    <li><a href="indicadores-sociais.php?ativo=conhecimento&sub=indicadores-sociais">Indicadores Sociais</a></li>
                    <li><a href="artigos-apresentacoes.php?ativo=conhecimento">Artigos e Apresentações </a></li>
                    <li><a href="comunicarte-midia.php?ativo=conhecimento">Comunicarte & Mídia</a></li>
                    <li><a href="fontes-pesquisa.php?ativo=conhecimento">Fontes de Pesquisa</a></li>
                    <li class="fimMenu"><a href="capacitacao.php?ativo=conhecimento">Capacitaçõess</a></li>
                </ul> 
           	</span>    
            
    </div>
			<!-- FINAL DO HTML DOS SUBMENUS - ATIVANDO OS SUBMENUS COM O JAVASCRIPT ABAIXO-->
	<script>
			
			$(function() {
			
            //FAZ FUNCIONAR A TRANSIO DE TABS
            $("#menus").tabs("span.description", {event:'mouseover'});
            
			//PARA QUE ELES NO APAREAM LOGO DE INCIO
			$('.submenus').hide();
            
			//ATIVANDO COM MOUSE OVER
            $('#menuquemsomos').mouseover(function(){
            $('.submenus').show();
			$('#np,#cc').removeClass("mouseOver");

            });
            $('#menunossosprojetos').mouseover(function(){
            $('.submenus').hide();
			$('#qs,#cc').removeClass("mouseOver");
            });
            $('#menunossosclientes').mouseover(function(){
            $('.submenus').hide();
			$('#qs,#np,#cc').removeClass("mouseOver");
            });
            $('#menuconhecimento').mouseover(function(){
            $('.submenus').show();
			$('#qs,#np').removeClass("mouseOver");
			});
		    $('#menunoticias').mouseover(function(){
            $('.submenus').hide();
		    $('#qs,#cc,#np').removeClass("mouseOver");
            });

            $('#quemsomos').mouseover(function(){
            $('#qs').addClass("mouseOver");
            });
			
			$('#nossosprojetos').mouseover(function(){
            $('#np').addClass("mouseOver");
            });

			$('#conhecimento').mouseover(function(){
            $('#cc').addClass("mouseOver");
            });
						            
			//DESATIVANDO
			
            $('.areaFlash').mouseover(function(){
            $('.submenus').hide();
			$('#qs,#cc,#np').removeClass("mouseOver");
            });
			$('.areaNoticias').mouseover(function(){
            $('.submenus').hide();
		    $('#qs,#cc,#np').removeClass("mouseOver");
            });

            });
            </script>
            <!-- FIM DO SCRIPT DO SUBMENU -->
            
    <!-- INCIO DO MEIO (BG TRANSPARENTE) -->
 		
    
  	<div>
    	  			
        <div class="areaFlash">
         <div style="width: 964px">
         <img src="images/bannergambiarra.gif"/>
			</div>
        <div>
        <table width="964" border="1" bgcolor=" #D0D0D0" bordercolor="#FFFFFF">
  <tbody>
    <tr>
		<td><a href="3e-sistema-gerencial.php"> <img src="images/1.jpg" width="231"/></a></td>
		<td><a href="relatorios-anuais.php"><img src="images/2.jpg" width="231"/></a></td>
		<td><a href="http://comunicarte.com.br/comunicartedigital/oportunidades-ods---comunicarte-digital.html" target="_blank"><img src="images/3.jpg" width="231"/></a></td>
		<td><a href="http://comunicarte.com.br/comunicartedigital/calendario-social---comunicarte-digital.html" target="_blank"><img src="images/4.jpg" width="231"/></a></td>
    </tr>
  </tbody>
</table>
			</div> 
     	</div>
     	

     	
      
            <!-- FIM DA REA FLASH - FLOAT:LEFT -->
     
             <!-- FIM DA REA BRANCA DE NOTCIAS - FLOAT:RIGHT -->
  	</div>
    <!-- FIM DO MEIO -->
   
     <!-- <div class="areaLinhaDoTempo">
       
     <div class="containerLinhaDoTempo"> 
		
		<img src="images/linhaDescubra.jpg" alt="Linha do tempo - descubra um pouco mais sobre a nossa história" style="float:left;margin:30px 15px 0 12px;"/>
        
              <div style="float:right;margin-right:8px;" >
              <ul id="mycarousel" class="jcarousel-skin-tango" >
                <li><a href="linha-do-tempo.php?ano=texto24&pos=1" id="item2015"></a></li>
				<li><a href="linha-do-tempo.php?ano=texto23&pos=2" id="item2014"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto22&pos=3" id="item2013"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto21&pos=4" id="item2012"></a></li>
	            <li><a href="linha-do-tempo.php?ano=texto20&pos=5" id="item2011"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto19&pos=6" id="item2010"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto18&pos=7" id="item2009"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto17&pos=8" id="item2008"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto16&pos=9" id="item2007"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto15&pos=10" id="item2006"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto14&pos=11" id="item2005"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto13&pos=12" id="item2004"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto12&pos=13" id="item2003"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto11&pos=14" id="item2002"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto10&pos=15" id="item2001"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto9&pos=16" id="item2000"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto8&pos=17" id="item1999"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto7&pos=18" id="item1998"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto6&pos=19" id="item1997"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto5&pos=20" id="item1996"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto4&pos=21" id="item1995"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto3&pos=22" id="item1994"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto2&pos=23" id="item1993"></a></li>
                <li><a href="linha-do-tempo.php?ano=texto1&pos=24" id="item1992"></a></li>
              </ul>
    		</div> 

    
      </div>

    </div> -->
    <!-- FIM DA REA LINHA DO TEMPO - BG BRANCO -->
	
	                             
<div class="areaDestaques">
    
    <div style="padding:1%; padding-top: 400px">
    <table width="964" border="0">
  <tbody>
    <tr>
      <td width="482">
       <div style="padding:5%; height: 250px">
		   
		   <div style="padding: 3%; font-size: 16px; color: #ff9900;"><b>Comunicação no Licenciamento Ambiental<b></div>
				
		   <p style="text-align: justify"><a href="downloads/COMUNICARTE_comunicacao_licenciamento.pdf" target="_blank">No processo de comunicação para licenciamento ambiental, a Comunicarte acompanha as fases de pesquisa, projeto, implantação e operação dos empreendimento buscando aliar o estabelecimento e fortalecimento das relações da empresa com seus stakeholders à obtenção das licenças prévias, de instalação, de operação e o atendimento às condicionantes. Nos últimos anos, a Comunicarte atendeu mais de 30 empreendimentos com foco no licenciamento ambiental. Os serviços incluem realização de diagnósticos socioambientais, preparação dos representantes da empresa cliente para participar nas audiências públicas, o alinhamento de discurso, implantação de programas específicos de comunicação social e de educação ambiental, dentre outros. Interessado em conhecer mais?</a></br></br>Entre em contato conosco: comunicarte@comunicarte.com.br</p>
    	</div>
    	</td>
    	
      <td width="482">
      <div style="padding:5%; height: 250px">
      			<div style="padding: 3%; font-size: 16px; color: #ff9900;"><b>Comunicação Integrada no Território<b></div>
								
				<p style="text-align: justify"><a href="downloads/COMUNICARTE_integracao_comunicacao.pdf" target="_blank">A integração das ações de comunicação e relacionamento com stakeholders chave no território onde o empreendimento pretende se instalar ou já se encontra em operação contempla as atividades planejadas por diversas áreas internas e/ou em cumprimentos a diferentes exigências.  As principais vantagens são: redução de custos;  oportunidade de estabelecimento de ponto focal de relacionamento e fortalecimento do relacionamento com stakeholders estratégicos; sistematização das ações; e facilidade de registro de evidências dos cumprimentos das condicionantes e diversos programas do PBA, elaborados para apresentação ao órgão ambiental
					Interessado em conhecer mais?</a></br></br>Entre em contato conosco: comunicarte@comunicarte.com.br</p>
		</div>
    </td>
    </tr>
    <tr>
      <td width="482">
      	 <div style="padding:5%; height: 300px">
				<div style="padding: 3%; font-size: 16px; color: #ff9900;"><b>3E - Sistema Gerencial <SOCIOAMBIENTAL></SOCIOAMBIENTAL><b></div>
				
				<p style="text-align: justify">A plataforma 3E-Socioambiental é um sistema de informação gerencial elaborada pela Comunicarte em 2006 e vem sendo utilizada para monitorar e avaliar os projetos socioambientais de acordo com as seguintes principais dimensões: processual (indicadores de gestão); e de resultados e impactos sociais (indicadores de retorno para público beneficiário e para a organização apoiadora). Adicionalmente, para cada projeto monitorado é calculado o seu índice de retorno, permitindo a análise comparativa dele mesmo em determinado período e/ou dele com outros projetos pertencentes à carteira de investimento. As informações geradas permitem planejar ações de melhorias em uma ou mais dimensões visando sempre o sucesso do investimento realizado pela organização.</br>
				Interessado em conhecer este sistema? Entre em contato conosco: comunicarte@comunicarte.com.br</br></br>Entre em contato conosco: comunicarte@comunicarte.com.br</p>
    	</div>
      </td>
      <td width="482">
      <div style="padding:5%; height: 300px">
				<div style="padding: 3%; font-size: 16px; color: #ff9900;"><b>EDUCOMUNICAÇÃO<b></div>
				
				<p style="text-align: justify">As estratégias de educomunicação propostas pela Comunciarte visam prover os reeditores de conteúdos relacionados aos temas sociais (saúde, educação, defesa dos direitos e deveres, promoção dos ODS, ética, economia criativa, responsabilidade social, meio ambiente, dentre outros). Trata-se de uma metodologia media to media com foco em ações de ENTERTAINMENT-EDUCATION, EDUTAINMENT e INFOTAINMENT. Se você já atua em um destes campos ou é um profissional de jornalismo, de entretenimento ou da comunidade escolar que tem interesse em adotar estratégias de educomunicação, entre em contato conosco: comunicarte@comunicarte.com.br</p>
    	</div>
    	</td>
    </tr>
  </tbody>
</table>

	</div> 
    
         
                           
           <div class="barraTidDestaques">
            	<img src="images/titProjetosExemplares.jpg" alt="Destaques" />
                
	  </div>
            <!-- FIM DO TTULO DESTAQUES INCIO DOS THUMBS DESTAQUES-->   
			
            	<ul>
                	<li style="padding-bottom:20px"><a href="destaque1.php"><img src="images/destaque1Home.jpg" alt="Programa de Comunica&ccedil;&atilde;o de Conviv&ecirc;ncia e Co-Responsabilidade das Comunidades Vizinhas &agrave; malha dutovi&aacute;ria da Transpetro " /></a><span><a href="destaque1.php">Relacionamento Comunit&aacute;rio</a></span>
                        <p><a href="destaque1.php">A Comunicarte foi pioneira na construção e implementação de programas de relacio-<br />
                        namento comunitário com foco no conceito de “Convivência e Corresponsabilidade”.</a></p>
               	  </li>
                        
                    <li style="padding-bottom:20px"><a href="destaque2.php"><img src="images/destaque2Home.jpg" alt="" /></a>
                    	<span><a href="destaque2.php">Pol&iacute;tica de Investimento Social</a></span>
                        <p><a href="destaque2.php">A Comunicarte elabora políticas de investimento social totalmente alinhadas às características das empresas. Um exemplo é o Banco de Tecnologias Sociais.</a><br />
                        </p></li>
                        
                    <li style="padding-bottom:20px"><a href="destaque3.php"><img src="images/destaque3Home.jpg" alt="" /></a>
                    	<span><a href="destaque3.php">Sistema de Informa&ccedil;&atilde;o Gerencial Socioambiental</a></span>
                        <p><a href="destaque3.php">O apoio a projetos sociais requer um sistema gerencial efetivo. Conheça nossa metodologia aplicada na Petrobras.</a></p>
                    </li>
                        
                    <li style="padding-bottom:20px"><a href="destaque4.php"><img src="images/destaque4Home.jpg" alt="CONHEA O PROGRAMA AGENTE JOVEM TRANSPETRO" /></a>
                        <span><a href="destaque4.php">Comunica&ccedil;&atilde;o no Licenciamento Ambiental</a></span>
                        <p><a href="destaque4.php">Nos  últimos anos, a Comunicarte atendeu mais de 30 empreendimentos em processo de  licenciamento ambiental. Saiba Mais!</a></p></br>
                    </li>
      </ul>
                    
    			                        
<br class="quebra" />
			<!-- FIM DOS THUMBS DESTAQUES--> 
	</div>
    <!-- FIM DA REA DESTAQUES - BG BRANCO -->
    
    <div id="quadradoRodape">
    </div> 
         
    <div class="divisorDestaques"></div> 
</div>
</div> 
	<!-- FIM DO GERAL (BG SOMBREADO) -->	
	</div>
     
	<!-- FIM DO CONTAINTER (BG CINZA DUPLO) -->   
	    <?php include"rodape.php"; ?>
        </body>
</html>
