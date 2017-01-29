<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién suspendemos hoy, en!?","TODOS LOS PROFESORES, SUPERPROFE INCLUIDO");
    $app->nav();
    $id = $_GET['id'];
    $profe = $app->editProfe($id);

    if(!$profe ){
                $this->showError("Error en la consulta");
            }else if (count($result = $profe->fetchAll())==0){
                $this->showError("No datos");
            } else {
                echo'</br>
                 <center>
                <label>EDITEMOS A UN PROFESOR, pero no abuses de poder.</label><br/>
                    <form method="POST" action="teachers.php">
                    <input type="hidden" name="id" value="'.$id.'"/>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nombre Profesor: </label>
                            
                            <input type="text" name="namep" value="'.$result[0]["user"].'" required> </input>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nueva Password: </label>
                            <input type="text" name="pass" required/>
                        </div>
                        
                        <input type="submit" class="btn btn-success btn-lg active" value="La junta se porta, Otro +" />
                    </form>
                </center>';
}
    $app->listProfes();
    $app->footer();
?>
       