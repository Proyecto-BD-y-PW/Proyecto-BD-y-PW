<?php
    
    $servidor="localhost";
    $db="inventarios";

    $usuario=$_POST['usr'];
    $password=$_POST['pwd'];

    $conexion=mysqli_connect($servidor,'root','',$db);
    if(!$conexion){
        echo "Fallo la conexión hacia la base de datos";
        echo "Error erno".mysqli_connect_errno().PHP_EOL;
        echo "Error de depuracion".mysqli_connect_error().PHP_EOL;
        die();
        
    }
    $op="SELECT * FROM usuario WHERE nombre='$usuario'";
    
    $resultado=mysqli_query($conexion,$op);
    $num=mysqli_num_rows($resultado);
    
    if($num>0){
        $row=mysqli_fetch_array($resultado);
        $op="SELECT * FROM mysql.user WHERE USER='$usuario'";    
        $resultado=mysqli_query($conexion,$op);
        $num=mysqli_num_rows($resultado);
        echo $num;
    
        if(password_verify($password,$row['contrasena']) && $num==0){
            echo "hi";
                $contra=$row['contrasena'];  
                $nombre=$row['nombre'];
                $op="CREATE USER '$nombre'@'localhost' IDENTIFIED BY '$contra'";
                if($row['privilegios']=="administrador"){
                    $permisos="ALL PRIVILEGES";
                }else if($row['privilegios']=="usuario-cap"){
                     $permisos="INSERT";
                    
                }else{
                     $permisos="SELECT";
                    
                }
                mysqli_query($conexion,$op);
                $op="GRANT ".$permisos." ON * . * TO '$nombre'@'localhost'";
                mysqli_query($conexion,$op);
                mysqli_close($conexion);
                
                $servidor="localhost";
                $usuario=$row['nombre'];
                $pass=$row['contrasena'];
                $db="inventarios";
            
                $conexion=mysqli_connect($servidor,'root','',$db);
                if(!$conexion){
                        echo "Fallo la conexión hacia la base de datos";
                        echo "Error erno".mysqli_connect_errno().PHP_EOL;
                        echo "Error de depuracion".mysqli_connect_error().PHP_EOL;
                    
        
                    }else{
                    echo "conexion exitosa";
                }
                die();
        }else if(password_verify($password,$row['contrasena']) && $num>0){
            
            $servidor="localhost";
                $usuario=$row['nombre'];
                $pass=$row['contrasena'];
                $db="inventarios";
            
                $conexion=mysqli_connect($servidor,'root','',$db);
                if(!$conexion){
                        echo "Fallo la conexión hacia la base de datos";
                        echo "Error erno".mysqli_connect_errno().PHP_EOL;
                        echo "Error de depuracion".mysqli_connect_error().PHP_EOL;
                    
        
                    }else{
                    echo "conexion exitosa";
                }
            
            
            mysqli_close($conexion);
            die();
        }
     
        $error="Contraseña Incorrecta";
    }else{
        
        $error="Lo siento, tu usuario aun no esta registrado";
    }

   
    

    

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $error?></title>
    <link href="https://file.myfontastic.com/zmGVYTk8c485ktmePB4HkF/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/estilos/normalize.css">
    <link rel="stylesheet" href="/estilos/estilos.css">
    
</head>
<body>
    <main class="contenedor">
    <form action="../index.html" method="post">
        
          <div class="input-field">
            <i class="icon-x"></i>
            <h2><?php echo $error?></h2>
             <i class="icon-x"></i>
            </div>
        
        <input type="submit" value="Regresar" name="btn" class="btn solid">
    </form>
        
        
    </main>
    
    
</body>
</html>