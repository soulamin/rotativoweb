<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row" style="background: url('../imagens/Ajuda.svg'); background-repeat: no-repeat;min-height:750px ">
     <span class="col-md-5 col-sm-5 text-lg text-primary" style="padding: 3%">
             <span class="btn-danger btn-lg">Fale Conosco</span><br><br>
           
            <span class="btn-primary btn-lg "><i class="fa fa-envelope-o"> suporte@brtecsistemas.com.br</i> </span><br><br>
            <span class="btn-primary btn-lg "><i class="fa fa-phone">Telefone : (21)9996-45984</i></span><br><br>
            <span class="btn-primary btn-lg" onclick="whatsapp()">
               
                <i class="fa fa-whatsapp"> WhatsApp</i></a>
           </span>     
      
     </span>
            </div>
    </div>
       
    <!------------------------------------Final do Modal---------------------------------------------->
    <?php
    $hr = time();
    include '../layout/footer.php';
    ?>
    <script>
  function whatsapp(){
       window.open("https://api.whatsapp.com/send?phone=5521999645984");
      }
    </script>
  

  