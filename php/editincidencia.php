<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién suspendemos hoy, en!?","EDITANDO UNA INCIDENCIA QUE NO DEBERIA CAMBIARSE, SINO A PEOR");
    $app->nav();
    $idIncidencia = $_GET['id'];
    $incid = $app->editIncidencia($idIncidencia);
    $desc = $app->getDao()->getIncidencia($idIncidencia);

    if(!$incid ){
         $this->showError("Error en la consulta");
        }else if (count($result = $incid->fetchAll())==0){
            $this->showError("No datos");
            } else {
                echo'</br>

<div class=\'card card-inverse card-sucess mb-3 text-center\'>
                <div class=\'card-block \'>
                    <blockquote class=\'card-blockquote padding\'>
                        <div class=\'margin\'>
                             <center>
                <label>EDITEMOS UNA INCIDENCIA, pero no seas muy debilucho con esos diablos</label><br/>
                    <form method="POST" action="incidences.php">
                    <input type="hidden" name="id" value="'.$idIncidencia.'"/>
                        <div class="form-group row">
                            <label class="col-2 col-form-label h2">Profesor Castigador:  '.$_SESSION['user'].' </label>

                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nombre Alumno: </label>
                            <input type="text" name="namea" value="'.$result[0]["name_alumno"].'" required> </input>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">TItulo de Incidencia: </label>
                            <input type="text" name="incid" value="'.$result[0]["title"].'" required> </input>
                        </div>
                        <div class="form-group row">
                        <br/>
                        <select name="description" required>';?>
                            <?php
                            $result = $app->getDao()->dameIncidencias();

                            foreach($result as $row){
                                echo"<option value=".$row[0].">".$row[1]."</option>";
                            }?>
                    <?php echo '
                        </select>
                    </div>
                    <div class="form-group row">
                <label for="example-date-input" class="col-2 col-form-label">Fecha FIN DEL MAL:</label>
                <input type="date" name="newdate" placeholder="yyyy-mm-dd" required>
             </div>
                    <div class="form-group row">
                        <input type="submit" class="btn btn-info btn-lg active" value="Estás cometiendo un error" />

                        </div>
                    </form>
                </center>
                        </div>
                    </blockquote
                </div><!-- /card-block -->
            </div>';
            }
            
    $app->footer();
?>
       