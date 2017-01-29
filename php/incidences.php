<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién suspendemos hoy, en!?","Incidencias del día");
    $app->nav();

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $namea =$_POST['namea'];
        $incid = $_POST['incid'];
        $description =$_POST['description'];
        $idIncid = $_POST['id'];
        $newDate = $_POST['newdate'];
        $insertado = $app->getDao()->otraIncidencia($idIncid,$namea, $incid,$description, $newDate);
    
        if($insertado){
            $app->showSuccess("INCIDENCIA ACTUALIZADA,(Grazia ".$_SESSION['user'].")");
        } else{
            $app->showError("INCIDENCIA NO ACTUALIZADA,(Mas ofendío Maeztra)");
        }
    }



    $app->listIncidencias();
    
    $app->footer();
?>