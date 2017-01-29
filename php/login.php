<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app
    $app->head( "Bienvenido a las incidencias del profesorado","Inicia Sesión");
    $app->loginCard();

//Control de errores e inicio de sesión

 if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $user = $_POST['user'];
        $password = $_POST['pass'];

        //Esto es absurdo con html 5
        if (empty($user)){
            $app->showError("Debes introducir un nombre");
        } else if (empty($password)) {
            $app->showError("Debes introducir una contraseña");
        } else{    //Conexion a la base de datos y comprobamos que existe el usuario.
            
            /** 1. Creamos la conexión */
            if(!$app->getDao()->isConnected()){
               $this->showErrorConnection();
            } else {
                 
                $userFin = $app->getDao()->checkUser($user, $password);
                if ($userFin != 0){
                       //Si todo es correcto guardamos la sesión t redireccionamos
                    $app->init_session($userFin);//iniciamos sesión
                
                } else {
                    $app->showError("No existe el usuario o contraseña incorrecta");
                }
            }
        }
        
    }

    $app->footer();    

?>