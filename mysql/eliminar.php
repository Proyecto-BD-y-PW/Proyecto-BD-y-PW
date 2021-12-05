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
        window.location='../index.html';
       </script>";
        die();
    }
    $pagina=$_SESSION['pagina'];
    if($pagina=="proveedor" || $pagina=="compra"){
        $pagina=$pagina."s";
    }    
 
    
    echo "<script>
        var reply=confirm('Estas seguro de que deseas continuar? ten en cuenta de que se eliminaran todos los registros que se relacionen con este(s)');
        if(!reply){
            window.location='../$pagina.php';
        
        }
        
    </script>"
    
    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
    $tipo_elim=$_POST['tipo-elim'];
    if(strcmp($tipo_elim,"todo")==0){
        $op="DELETE FROM $pagina";
        mysqli_query($conexion,$op);
    }else if(strcmp($tipo_elim,"almacen")==0){

    }else if(strcmp($tipo_elim,"arquitectura")==0){
        
    }else if(strcmp($tipo_elim,"catalogo_pieza")==0){
        
    }else if(strcmp($tipo_elim,"cliente")==0){
        
    }else if(strcmp($tipo_elim,"compra")==0){
        
    }else if(strcmp($tipo_elim,"empleado")==0){
        
    }else if(strcmp($tipo_elim,"modelo")==0){
        
    }else if(strcmp($tipo_elim,"pieza_armado")==0){
        
    }else if(strcmp($tipo_elim,"pieza_venta")==0){
        
    }else if(strcmp($tipo_elim,"pieza")==0){
        
    }else if(strcmp($tipo_elim,"producto")==0){
        
    }else if(strcmp($tipo_elim,"proveedor")==0){
        
    }else if(strcmp($tipo_elim,"venta")==0){
        
        
        
    }
    mysqli_close($conexion);
?>

