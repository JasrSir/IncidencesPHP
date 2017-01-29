<?php
  include_once 'php/app.php';

    global $app;      //creamos una variable global de la clase app
    $app = new App(); //La inicializamos

        $app->start_session();

?>
    
