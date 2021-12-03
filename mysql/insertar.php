<?php
    

    session_start();
    
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $pagina=$_SESSION['pagina'];
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
    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
    
    echo $pagina;
    if(strcmp($pagina,"modelo")==0){
        $nombre=$_POST['nombre'];
        $id_arquitectura=$_POST['id-arquitectura'];
        
        $op="INSERT INTO modelo(nombre,estatus,id_arquitectura) VALUES ('$nombre',1,'$id_arquitectura')";
        mysqli_query($conexion,$op);
        echo $nombre." ".$id_arquitectura;
    }else if(strcmp($pagina,"arquitectura")==0){
        $tipo=$_POST['tipo'];
        $op="INSERT INTO arquitectura(tipo,estatus) VALUES ('$tipo',1)";
        mysqli_query($conexion,$op);
        
        
    }else if(strcmp($pagina,"cliente")==0){
        
        
        
    }else if(strcmp($pagina,"compra")==0){
        
    }else if(strcmp($pagina,"pieza")==0){
        
    }else if(strcmp($pagina,"producto")==0){
        
    }else if(strcmp($pagina,"proveedor")==0){
        /*ya esta por parte de juca*/
    }else if(strcmp($pagina,"venta")==0){
        
        
    }else if(strcmp($pagina,"almacen")==0){
        
    }

    mysqli_close($conexion);

?>