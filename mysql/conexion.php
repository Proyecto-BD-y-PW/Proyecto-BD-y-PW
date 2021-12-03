<?php
    function logIn($user,$password){
        $servidor="localhost";
        $usuario=$user;
        $contrasena=$password;
        $db="inventarios";

        $conexion=mysqli_connect($servidor,$usuario,$contrasena,$db);
        if(!$conexion){
        
            echo "Fallo al autenticar a la base de datos";
            echo "Error erno".mysqli_connect_errno().PHP_EOL;
            echo "Error de depuracion".mysqli_connect_error().PHP_EOL;
        
        }else{
            $query="SELECT * FROM usuario WHERE nombre='$user'";
            $res=mysqli_query($conexion,$query);
            $row=mysqli_fetch_array($res);
            session_start();
            $_SESSION['user']=$user;
            $_SESSION['password']=$password;
            $_SESSION['privilegios']=$row['privilegios'];
            $_SESSION['conexion']=$conexion;
            mysqli_close($conexion);
            header("location:../paginas/proveedores.php");
        }
    }

    function close($conn){
        mysqli_close($conn);
        
        
    }


?>