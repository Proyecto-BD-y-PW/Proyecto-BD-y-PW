<?php
    include("../mysql/conexion.php");
    $servidor="localhost";
    $db="inventarios";
    $db2="mysql";
    $usuario=$_POST['usr'];
    $password=$_POST['pwd'];

    $conexion=mysqli_connect($servidor,'root','',$db);
    $conexion2=mysqli_connect($servidor,'root','',$db2);
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
                $op="FLUSH PRIVILEGES";
                mysqli_query($conexion,$op);
            
                
                $op="GRANT ".$permisos." ON * . * TO '$nombre'@'localhost'";
                mysqli_query($conexion,$op);
                mysqli_close($conexion);
                mysqli_close($conexion2);
                
            
                $conn=logIn($row['nombre'],$row['contrasena']);
                
                die();
        }else if(password_verify($password,$row['contrasena']) && $num>0){
            $nombre=$row['nombre'];
            $contra=$row['contrasena'];  
            $op="DELETE FROM mysql.user WHERE user='$nombre'";
            mysqli_query($conexion,$op);
             $op="FLUSH PRIVILEGES";
            mysqli_query($conexion,$op);
           
            $op="CREATE USER '$nombre'@'localhost' IDENTIFIED BY '$contra'";
                
            if($row['privilegios']=="administrador"){
                    $permisos="ALL PRIVILEGES";
            }else if($row['privilegios']=="usuario-cap"){
                     $permisos="INSERT";
                    
            }else{
                     $permisos="SELECT";
                    
            }
            mysqli_query($conexion,$op);
            $op="FLUSH PRIVILEGES";
            mysqli_query($conexion,$op);
            
            $op="GRANT ".$permisos." ON * . * TO '$nombre'@'localhost'";
             mysqli_query($conexion,$op);
               
            $op="FLUSH PRIVILEGES";
            mysqli_query($conexion,$op);
            mysqli_close($conexion);
            mysqli_close($conexion2);
            $conn=logIn($row['nombre'],$row['contrasena']);                
            die();
        }
     
        $error="Contraseña Incorrecta";
    }else{
        
       /* verificamos que el usuario tampoco este en base de datos mysql.user*/
        $op="SELECT * FROM mysql.user WHERE USER='$usuario'";    
        $resultado=mysqli_query($conexion2,$op);
        $num=mysqli_num_rows($resultado);
        if($num>0){
          /*quiere decir que ya existe en la base de datos mysql*/
          /*Para evitar fallos relacionados con el error 1045 lo borramos */
            $op="DELETE FROM mysql.user WHERE USER='$usuario'";    
            $resultado=mysqli_query($conexion,$op);
        
        }else{
            
        }
         mysqli_close($conexion);
         mysqli_close($conexion2);
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

