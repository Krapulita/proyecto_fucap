<?php 
include "header.php";
include "navbar.php";
?>



<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-4 text-center">
      <h2>Agenda Tu cita</h2>
      <h5>Garras Y Tuercas:</h5>
      <img src="img/logomecanico.jpeg" class="rounded mx-auto d-block border" width="80%" alt="...">
      <p><kbd>Contactanos</kbd></p>
      
      <ul class="nav nav-pills flex-column">
        
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>
      </ul>
      <hr class="d-sm-none">
    </div>

    
    <div class="col-sm-8">
      <div class="text-justify">
          <p class="alert alert-info">Has clic en el siguiente botón para iniciar tu reserva en el sistema, en cuánto sea procesada
            se te enviará un mensaje de confirmación al correo electrónico que ingreses en el formulario. 
            <br><b>Una forma mas fácil de reservar con un solo clic"</b>.
          </p>
      </div>
      <?php 
        include "modal_reserva.php";
        #include "metodos/form_insert.php";
      ?>

      <hr>
      <div class="text-justify">
          <p class="alert alert-warning">Quieres consultar el estatus de tu reserva?, no has recibido el mensaje
            de confirmación o falló el envio?.
          </p>
      </div>


    </div>
  </div>
</div>





<?php include "footer.php";?>