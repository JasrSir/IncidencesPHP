<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién metemos en el club hoy, en!?","INTRODUCE UN NUEVO PROFESOR");
    $app->nav();


 
                echo'</br>
                 <center>
                <label>Crea un nuevo Profesor, pero no abuses de poder.</label><br/>
                    <form method="POST" action="'.$_SERVER["PHP_SELF"].'">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nombre Profesor: </label>
                            <input type="text" name="namep"  required> </input>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nueva Password: </label>
                            <input type="text" name="pass" required/>
                        </div>
                         <input type="hidden" name="otro" value="ok"/>
                        <input type="submit" class="btn btn-success btn-lg active" value="La junta se porta, Otro +" />
                    </form>
                </center>';
        
        if($_SERVER["REQUEST_METHOD"]=="POST" ){
            if(isset($_POST['otro'])){
                $name =$_POST['namep'];
                $pass = $_POST['pass'];
                $insertado = $app->getDao()->newTeacher($name, $pass);
                if($insertado){
                    $app->showSuccess("PROFESORADO INSERTADO Y TRAVESURA REALIZADA");
                } else{
                    $app->showError("PROFESORADO NO INSERTADO Y TRAVESURA CHAFADA");
                }
            } else{
                $app->showInfo("Mete en el club a tu compi profe favorito");
            }
        }
    

    $app->listProfes();
    $app->footer();
?>