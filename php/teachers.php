<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién suspendemos hoy, en!?","TODOS LOS PROFESORES, SUPERPROFE INCLUIDO");
    $app->nav();
    
    
   
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name =$_POST['namep'];
    $pass = $_POST['pass'];
    $id = $_POST['id'];
    $insertado = $app->getDao()->otroTeacher($name, $pass, $id);
    
    if($insertado){
        $app->showSuccess("PROFESORADO AGRADECIDO REALIZADA");
    } else{
        $app->showError("PROFESORADO NO CONTENTO Y CHAFADO");
    }
}
$app->listProfes();
echo' <center>
    <form method="POST" action="addteacher.php">
            
            <input type="submit" class="btn btn-success btn-lg active" value="Mete a otro profe en el club" />
     </form></center>';
    $app->footer();
?>