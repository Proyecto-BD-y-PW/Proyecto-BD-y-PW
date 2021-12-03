<?php

    $servidor="localhost";
    $usuario=$_POST['usr'];
    $email=$_POST['em'];
    $t_acceso=$_POST['tipo-acceso'];
    $password=$_POST['pwd'];
    $db="usuario";
    
    $conexion=mysqli_connect($servidor,'root','','inventarios');
    if(!$conexion){
        echo "Fallo la conexión hacia la base de datos";
        echo "Error erno".mysqli_connect_errno().PHP_EOL;
        echo "Error de depuracion".mysqli_connect_error().PHP_EOL;
        die();
        
    }
    

    $pass=password_hash($password,PASSWORD_DEFAULT);
    $op="INSERT INTO usuario (nombre,correo,contrasena,privilegios) VALUES('$usuario','$email','$pass','$t_acceso')";
    mysqli_query($conexion,$op);

    mysqli_close($conexion);

    header("location:../index.html")
?>