<?php

    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    
    if($usuario=="" && $pass==""){
        
       echo "<script>
       var reply=confirm('No se ha iniciado sesion');
        if(reply){
            window.location='../index.html';
        
        }
       </script>";
        die();
    }


?>