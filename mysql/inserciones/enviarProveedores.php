<?php
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    
    $servidor="localhost";
    $db="inventarios";

    if($usuario=="" && $pass==""){
        
       echo "<script>
       var reply=confirm('No se ha iniciado sesion');
        if(reply){
            window.location='../index.html';
        
        }
       </script>";
        die();
    }
$RFC=$_POST['rfc'];
$empresa=$_POST['empresa'];
$nombre=$_POST['nproveedor'];
$descripcion=$_POST['descripcion'];
$producto='ram';
$telefono=$_POST['telefono'];
$email=$_POST['correo'];
$conexion=mysqli_connect($servidor,$usuario,$pass,$db);
if(!$conexion){
        
            echo "Fallo al autenticar a la base de datos";
            echo "Error erno".mysqli_connect_errno().PHP_EOL;
            echo "Error de depuracion".mysqli_connect_error().PHP_EOL;
        
        }
$query="INSERT INTO proveedores (RFC,empresa,nombre_proveedor,descripcion,producto,telefono,email)VALUES ('$RFC','$empresa','$nombre','$descripcion','$producto','$telefono','$email')";
mysqli_query($conexion,$query);
header('location:../../paginas/proveedores.php');
/*$query="INSERT INTO proveedor (nombres,apellidos,correo,password,sexo,nivel_estudios,dia,comentarios)VALUES ('$var_nombres','$var_apellidos','$var_correo','$var_password','$var_sexo','$var_estudios','$var_dia','$var_comentarios')";
mysqli_query($conexion,$query);*/
    
?>