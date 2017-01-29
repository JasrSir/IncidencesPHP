<?php
    include_once('app.php');
    session_start();
    $app = new App(); // Nos creamos un objeto de nuestra app

    //Cogemos el id y ponemos el INT de borrado a 1
    $idinc =$_GET['id'];
    $app->getDao()->deleteTeacher($idinc);
    header('Location:teachers.php')

?>