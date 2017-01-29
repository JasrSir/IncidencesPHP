<?php
    include_once('app.php');
    session_start();
    global $app;
    $app = new App();
    $app->destroy_session();

?>