<?php
    include("../mysql/conexion.php");
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
                
            
                $conn=logIn($nombre,$contra);
                
                die();
        }else if(password_verify($password,$row['contrasena']) && $num>0){
            
            $conn=logIn($row['nombre'],$row['contrasena']);                
            die();
        }
     
        $error="Contraseña Incorrecta";
    }else{
        
        $error="Lo siento, tu usuario aun no esta registrado";
    }

   echo "<script>
       var reply=confirm('$error');
       if(reply){
            window.location='../index.html';
        
       }else{
            window.location='../index.html';
        
       
       }
   </script>";
   
    sleep(1);
   
?>

