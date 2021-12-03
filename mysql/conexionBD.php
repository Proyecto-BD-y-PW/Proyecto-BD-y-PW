<?php
        $servidor="localhost";
        $db="inventarios";
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
        password_verify($pass,$contrasena);
        /*REALIZAMOS LA CONEXION A LA BASE DE DATOS CON LOS PARAMETROS ANTERIORMENTE SOLICITADOS*/
        $conexion=mysqli_connect($servidor,$usuario,$contrasena,$db);
        if(!$conexion){
            echo "Error: no se puede conectar a la base de datos de MySQL ".PHP_EOL;
            echo "Errno de depuracion: ".mysqli_connect_errno().PHP_EOL;
            echo "Errno de depuracion: ".mysqli_connect_error().PHP_EOL;
            exit;
        }

?>