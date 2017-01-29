<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app

    //BORRAMOS LA INCIDENCIA
    $idinc =$_GET['id'];
    $app->getDao()->deleteIncidencia($idinc);
    header('Location:incidences.php')
?>
