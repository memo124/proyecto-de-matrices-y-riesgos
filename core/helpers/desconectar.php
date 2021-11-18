<?php
    session_start();
    if($_SESSION['USER_ID']){
        session_destroy();
        header("location: /Matrices/ExpoTecnica/views/Sitio/index.php");
    }
    else{
        header("location: /Matrices/ExpoTecnica/views/Sitio/index.php");
    }
?>