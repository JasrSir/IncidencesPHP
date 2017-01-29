<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién suspendemos hoy, en!?","BUSCADOR DE INCIDENCIAS");
    $app->nav();
    //$app->listIncidenciasEntre();
    

?>
 <br/><br/>
        <div class='card card-sucess mb-3 text-center'>
                <div class='card-block '>
                    <blockquote class='card-blockquote padding'>
                        <div class='margin'>
                            <center>
                                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                    <div class="form-group row">
                                        <label for="example-date-input" class="col-2 col-form-label">Fecha INICIO DEL MAL:</label>
                                        <input type="date" name="start" placeholder="yyyy-mm-dd">
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-date-input" class="col-2 col-form-label">Fecha FIN DEL MAL:</label>
                                        <input type="date" name="end" placeholder="yyyy-mm-dd">
                                    </div>

                                    <input type="submit" class="btn btn-success btn-lg active" value="Buscar alumnos malos" />
                                </form>
                            </center>
                        </div>
                    </blockquote>
                </div><!-- /card-block -->
            </div>
    

<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $desde=$_POST['start'];
    $hasta=$_POST['end'];
    if($desde > $hasta){
        $app->showError("La fecha inicial no puede ser mayor que la fecha final");
    } else if ($desde < $hasta){
        $incidences= $app->getDao()->filtroIncidencias($desde, $hasta);
         
            if(!$incidences ){
                $app->showError("Error en la consulta");
            }else if (count($result = $incidences->fetchAll())==0){
                $app->showError("NO hay incidencias para estas fechas tan esperadas");
            } else {
                        
                $app->showInfo("Aquí aparecen los resultados de la búsqueda");
                 echo " </br>
                    <table class='table'>
                        <thead class='thead-default'>
                            <tr>
                                <th>Profesor</th>
                                <th>Nombre del Alumno</th>
                                <th>Título</th>
                                <th>Incicencia</th>
                                <th>Fecha del alboroto</th>
                            </tr>
                        </thead>";
       

                        foreach($result as $fila){
                            $autorid = $app->getDao()->getNameProfe($fila[1]);
                            $incidenciatipo = $app->getDao()->getIncidencia($fila[4]);
                            echo"
                            <tr>";
                            for ($i=1; $i < $incidences->columnCount(); $i++) { 
                                if($i== 4){
                                    echo"<td>".$incidenciatipo."</td>";
                                } else if($i== 1){
                                    echo '<td>' . $autorid . '</td>';
                                } else{
                                    echo '<td>' . $fila[$i] . '</td>';
                                }
                            }
                                
                            echo"</tr>";
                        }
                    
                    echo"
                        </tbody>
                    </table> </br>";
            }
           
        }
    }


    $app->footer();
?>