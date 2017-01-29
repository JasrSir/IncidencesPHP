<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Hola Profesor/a ". $_SESSION['user']." ¿A quién suspendemos hoy, en!?","ADJUNTA UNA NUEVA INCIDENCIA");
    $app->nav();

?> 

 <center>
    <label>Otra incidencia, son malos los alumnos, ¿no crees?</label><br/>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
            <div class="form-group row">
                <label class="col-2 col-form-label">Alumno Malvado: </label>
                <input type="text" name="name" required/>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Titulo Fechoria: </label>
                <input type="text" name="title" required/>
            </div>
            <div class="form-group row">
                <br/>
                <select name="description" required>
                    <?php
                    $result = $app->getDao()->dameIncidencias();

                    foreach($result as $row){
                        echo"<option value=".$row[0].">".$row[1]."</option>";
                    }?>

                </select>
            </div>
            <input type="submit" class="btn btn-warning btn-lg active" value="Otra Incidencia +" />
        </form>
    </center>

<?php   
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $description =$_POST['description'];
    $name =$_POST['name'];
    $title = $_POST['title'];
    $insertado = $app->getDao()->otraIncidenciaMas($_SESSION['id'],$name, $title,$description);
    
    if($insertado){
        $app->showSuccess("TRAVESURA REALIZADA");
    } else{
        $app->showError("TRAVESURA CHAFADA");
    }
}

      $app->footer();
?>