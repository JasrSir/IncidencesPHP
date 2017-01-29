<?php
    //Incluye al dao 
    include('dao.php');
    
    class App{
        //objeto protegido dao 
        protected $dao;

        function __construct(){
            $this->dao = new Dao();
        }

        function head($h1, $h2=null){
            
            echo"
                <!DOCTYPE html>
                <html lang= \"es\">
                <head >
                    <meta charset=\"utf-8\" />
                    <title>Incidencias Portada</title>
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
                    <link href='../css/bootstrap.min.css' rel='stylesheet' media='screen'>
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/style.css\" />
                    <link href='../css/bootstrap-responsive.min.css' rel='stylesheet' media='screen'>
                    <script src='js/vendor/modernizr-2.6.2-respond-1.1.0.min.js'></script>
                    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
                    <!-- Include all compiled plugins (below), or include individual files as needed -->
                    <script src=\"../js/bootstrap.min.js\"></script>
                </head>

                <body class='body'>
            
                   <div class=\"panel panel-default panel-info\">
                        <div class=\"panel-heading h2\">".$h1."</div>
                       <div class=\"panel-body h4\">".$h2."</div>
                    ";
        }

        function nav(){
            if ($_SESSION['user'] == 'superprofe'){
            echo "
                <ul class='nav nav-pills nav-fill nav-justified primary'>
                    <li class='nav-item nav-inverse'><a href='incidences.php'>Incidencias de HOY</a></li>
                    <li class='nav-item nav-inverse'><a href='registro.php'>TODAS las Incidencias</a></li>
                    <li class='nav-item'><a href='addincidencia.php'>Una incidencia MAS</a></li>
                    <li class='nav-item nav-inverse'><a href='lookincidencias.php'>Buscar Incidencias</a></li>
                    <li class='nav-item'><a href='teachers.php'>Profesores</a></li>
                    <li class='nav-item'><a href='logout.php'>Logout</a></li>
                </ul> ";
            } else {
                echo "
                <ul class='nav nav-pills nav-fill nav-justified primary'>
                    <li class='nav-item nav-inverse'><a href='incidences.php'>Incidencias de HOY</a></li>
                    <li class='nav-item'><a href='addincidencia.php'>Una incidencia MAS</a></li>
                    <li class='nav-item'><a href='lookincidencias.php'>Busca Incidencias</a></li>
                    <li class='nav-item'><a href='logout.php'>Logout</a></li>
                </ul> ";
            }
           
        }

        /**
        * Footer
        */
        function footer(){
            echo "
                <div class=\"panel-footer\">
                Página realizada por: Juan Antonio Suárez Rosa
                </div>
                </div>
            </body>
            </html>";
        }
        
         /**
        * Show a message error
        */
        function showError($string){
            echo "
            <div class='alert alert-danger margin'>
            <p class='close' data-dismiss='alert'>X</p>
            <p><strong>Error! </strong>".$string."</p>
            </div>";
        }

         /**
        * Show a Success message
        */
        function showSuccess($string){
            echo "
            <div class='alert alert-success margin'>
            <p class='close' data-dismiss='alert'>X</p>
            <p><strong>Genial! </strong>".$string."</p>
            </div>";
        }


         /**
        * Show an info message
        */
        function showInfo($string){
            echo "
            <div class='alert alert-info margin'>
            <p class='close' data-dismiss='alert'>X</p>
            <p><strong>Información! </strong>".$string."</p>
            </div>";
        }

        function loginCard(){
            echo "
            <div class='card card-inverse card-sucess mb-3 text-center'>
                <div class='card-block '>
                    <blockquote class='card-blockquote padding'>
                        <div class='margin'>
                            <form class='form-signin margin' action='login.php' method='POST' >
                                <input type='text' id='inputEmail' name='user' class='form-control ' placeholder='Nombre de profesor'>
                                <input type='password' id='inputPassword' name='pass' class='form-control ' placeholder='Contraseña' required>             
                                <button class='btn btn-lg btn-info btn-block btn-signin' type='submit' method='POST'>Si, soy profesor</button>
                            </form><!-- /form -->
                        </div>
                    </blockquote
                </div><!-- /card-block -->
            </div>";
        }
        
        
    
      /**
        * Funcion que comprueba si el usuario está registrado en la web
        */
        function isLogged(){
            if (!isset($_SESSION['user'])){
                return false;
            }
            return true;
        }

        /**
        * Funcion que inicia sesion y si no esta logueado redirecciona a login
        */
        function start_session(){
            session_start();  //1-Hay que llamar a session_start siempre. y cada vez que se refresque la pagina.
            if (!$this->isLogged()){
                $this->showLogin();
            } else {
                $this->showHome();
            } 
        }

         /**
        * Funcion que inicia sesión en la pagina
        */
        function init_session($user){
            $_SESSION['user'] = $user['user'];
            $_SESSION['id'] = $user['id'];
            $this->showHomePostLogin();
        }

        /**
        * Funcion que cierra sesión en la pagina
        */
        function destroy_session(){
            if (isset($_SESSION['user'])) //Si no es nulo ni vacio
                unset($_SESSION['user']); //Lo deseleccionamos
            session_destroy(); //destruimos la sesion
            $this->showIndex();
        }


        function showLogin(){
            header('Location: php/login.php');
        }

        function showHomePostLogin(){
            header('Location: incidences.php');
        }
        function showHome(){
            header('Location: php/incidences.php');
        }


        function showIndex(){
            header('Location: ../index.php');
        }

        function showErrorConnection(){
            echo "<p>".$this->dao->error."</p>";
        }

        function getDao(){
            return $this->dao;
        }

        /**
        *Function que lista  incidencias de hoy
        */
        function listIncidencias(){

            $incidences = $this->getDao()->listarIncidenciasToday();
            
            if(!$incidences ){
                $this->showError("Error en la consulta");
            }else if (count($result = $incidences->fetchAll())==0){
                $this->showError("No datos");
            } else {
                
                 echo" </br>
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
                            $autorid = $this->getDao()->getNameProfe($fila[1]);
                            $incidenciatipo = $this->getDao()->getIncidencia($fila[4]);
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
                                if($_SESSION['user'] == 'superprofe' || $_SESSION['user'] == $autorid){
                                    echo '<td><form action="editincidencia.php?&id=" method="GET"><input type="hidden" value="'.$fila[0].'" name="id"/><input class="btn btn-warning btn-sm" type="submit" value="Editar"/></form></td>';
                                    echo '<td><form action="deleteincidence.php?&id=" method="GET"><input type="hidden" value="'.$fila[0].'" name="id"/><input class="btn btn-danger btn-sm" type="submit" value="Borrar"/></form></td>';
                                } 
                                echo"</tr>";
                        }
                    
                    echo"
                        </tbody>
                    </table> </br>
                    ";
            }
           
        }

        /**
        *Function que lista  incidencias de hoy
        */
        function listIncidenciasAll(){

            $incidences = $this->getDao()->listarIncidenciasAll();
            
            if(!$incidences ){
                $this->showError("Error en la consulta");
            }else if (count($result = $incidences->fetchAll())==0){
                $this->showError("No datos");
            } else {
                
                 echo" </br>
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
                            $autorid = $this->getDao()->getNameProfe($fila[1]);
                            $incidenciatipo = $this->getDao()->getIncidencia($fila[4]);
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
                                if($_SESSION['user'] == 'superprofe' || $_SESSION['user'] == $autorid){ //editIncidence.php
                                    echo '<td><form action="editincidencia.php?&id=" method="GET"><input type="hidden" value="'.$fila[0].'" name="id"/><input class="btn btn-warning btn-sm" type="submit" value="Editar"/></form></td>';
                                    echo '<td><form action="deleteincidence.php?&id=" method="GET"><input type="hidden" value="'.$fila[0].'" name="id"/><input class="btn btn-danger btn-sm" type="submit" value="Borrar"/></form></td>';
                                } 
                                echo"</tr>";
                        }
                    
                    echo"
                        </tbody>
                    </table> </br>
                    ";
            }
           
        }


        function listProfes(){
            $profes = $this->getDao()->listarProfes();
            
            if(!$profes ){
                $this->showError("Error en la consulta");
            }else if (count($result = $profes->fetchAll())==0){
                $this->showError("No datos");
            } else {
                
                 echo" </br>
                    <table class='table'>
                        <thead class='thead-default'>
                            <tr>
                                <th>idProfe</th>
                                <th>Nombre Profesor</th>
                                <th>Password</th>
                            </tr>
                        </thead>";
                        
                        foreach($result as $fila){
                            echo"
                            <tr>";
                             
                            for ($i=0; $i < $profes->columnCount(); $i++) { 
                                    if($i < $profes->columnCount()-1 && $fila[$profes->columnCount()-1] == 0){
                                        echo"<td>".$fila[$i]."</td>";
                                    }
                            }
                                if($fila[$profes->columnCount()-1] == 0){
                                    echo '<td><form action="editteacher.php?&id=" method="GET"><input type="hidden" value="'.$fila[0].'" name="id"/><input class="btn btn-warning btn-sm" type="submit" value="Editar"/></form></td>';
                                    echo '<td><form action="deleteteacher.php?&id=" method="GET"><input type="hidden" value="'.$fila[0].'" name="id"/><input class="btn btn-danger btn-sm" type="submit" value="Borrar"/></form></td>';
                                echo"</tr>";
                                }
                                    
                        }
                    
                    echo"
                        </tbody>
                    </table> </br>
                    ";
            }
        }

        function editProfe($id){
            $profe = $this->getDao()->getProfe($id);
            return $profe;
        }

        function editIncidencia($id){
            $incidencia = $this->getDao()->getIncidence($id);
            return $incidencia;
        }
    }
    
?>

  
        
