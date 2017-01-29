<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién suspendemos hoy, en!?","REGISTRO DE INCIDENCIAS");
    $app->nav();
    $app->listIncidenciasAll();
    
    $app->footer();
?>