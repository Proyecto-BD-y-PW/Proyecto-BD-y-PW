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
    if($pagina=="proveedor" ){
        $pagina=$pagina."es";
    }    else if( $pagina=="compra"){
        $pagina=$pagina."s";
    }
 
    
    echo "<script>
        var reply=confirm('Estas seguro de que deseas continuar? ten en cuenta de que se eliminaran todos los registros que se relacionen con este(s)');
        if(!reply){
            window.location='../$pagina.php';
        
        }
        
    </script>";
    
    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
    $tipo_elim=$_POST['tipo-elim'];
    if(strcmp($tipo_elim,"todo")==0){
        /*$op="DELETE FROM $pagina";
        mysqli_query($conexion,$op);
       */ 
        if($pagina=="arquitectura" || $pagina=="catalogo_pieza" || $pagina=="cliente"
           || $pagina=="empleado" || $pagina=="pieza" || $pagina=="producto" || $pagina=="venta"
          
          ){
            $pagina=$pagina."s";
            
        }else{
            
            
        }
        header("location: ../paginas/$pagina.php");
        
   }else if(strcmp($pagina,"almacen")==0){
        $id=$_POST['id-elim'];
        $op="DELETE FROM almacen WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        header("location:../paginas/almacen.php");
    }else if(strcmp($pagina,"arquitectura")==0){
        $id=$_POST['id-elim'];
        $op="UPDATE arquitectura SET estatus='0' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        
        header("location:../paginas/arquitecturas.php");
    }else if(strcmp($pagina,"catalogo_pieza")==0){
        $nombremodelo=$_POST['id-elim'];
        $separada=explode("*",$nombremodelo);
        $nombre="";
        $band=true;
        $modelo="";
        $tamaño=sizeof($separada);
       foreach($separada as $valor){
            if($band){
                $nombre=$valor;
                $band=false;
            }else{
                $modelo=$valor;
            }
        }
        $op="DELETE FROM catalogo_pieza WHERE nombre='$nombre' AND modelo='$modelo'";
        mysqli_query($conexion,$op);
        header("location:../paginas/catalogo_piezas.php");
    }else if(strcmp($pagina,"cliente")==0){
        $rfc=$_POST['id-elim'];
        $op="DELETE FROM cliente WHERE RFC='$rfc'";
        mysqli_query($conexion,$op);
        
        header("location:../paginas/clientes.php");
    }else if(strcmp($pagina,"compras")==0){
        $tipo_elim=$_POST['tipo-elim'];
        if(strcmp($tipo_elim,"unico-id")==0){
            $id=$_POST['id-elim'];
            $op="UPDATE compras SET estatus='0' WHERE id='$id'";
            mysqli_query($conexion,$op);
            
        }else{
            $fecha=$_POST['fecha'];
            $op="UPDATE compras SET estatus='0' WHERE fecha='$fecha'";
            mysqli_query($conexion,$op);
            
            
            
        }
        
        header("location:../paginas/compras.php");
    }else if(strcmp($pagina,"empleado")==0){
        $id=$_POST['id-elim'];
        $op="UPDATE empleado SET estatus='0' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        header("location:../paginas/empleados.php");
    }else if(strcmp($pagina,"modelo")==0){
        $nombre=$_POST['id-elim'];
        $op="UPDATE modelo SET estatus='0' WHERE nombre='$nombre'";
        mysqli_query($conexion,$op);
        header("location:../paginas/modelo.php");
        
    }else if(strcmp($pagina,"pieza_armado")==0){
        
        $tipo_elim=$_POST['tipo-elim'];
        if(strcmp($tipo_elim,"unico-id")==0){
           $id=$_POST['id-elim'];
            $op="DELETE FROM pieza WHERE id='$id'";
            mysqli_query($conexion,$op);
        
            
        }else{
            $fecha=$_POST['fecha'];
        
            $op="SELECT * FROM compras WHERE fecha='$fecha'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $id=$row['id'];
            $op="DELETE FROM pieza WHERE id='$id'";
            mysqli_query($conexion,$op);
            
            
            
        }
        header("location:../paginas/pieza_armado.php");
    }else if(strcmp($pagina,"pieza_venta")==0){
        
         $tipo_elim=$_POST['tipo-elim'];
        if(strcmp($tipo_elim,"unico-id")==0){
            $id=$_POST['id-elim'];
            $op="SELECT * FROM pieza WHERE id='$id'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $nombre=$row['nombre'];
            $modelo=$row['modelo'];
            $op="SELECT * FROM pieza p JOIN catalogo_pieza c ON c.nombre='$nombre' AND c.modelo='$modelo'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $precio=$row['precio'];
            $id_almacen=$row['id_almacen'];
            
            $op="SELECT * FROM almacen WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $capital=$row['capital']-$precio;
            $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            
            
            $op="UPDATE producto SET en_almacen='0' WHERE no_serie='$no_serie'";
            mysqli_query($conexion,$op);
            
            
        }else{
            $fecha=$_POST['fecha'];
        
            $op="SELECT pieza.id FROM pieza JOIN compras ON pieza.id_compras=compras.id AND compras.fecha='$fecha'";
            $resultado=mysqli_query($conexion,$op);
            
            while($row=mysqli_fetch_array($resultado)){
                $id=$nombre=$row['id'];    
                $nombre=$row['nombre'];
                $modelo=$row['modelo'];
                $op="SELECT * FROM pieza p JOIN catalogo_pieza c ON c.nombre='$nombre' AND c.modelo='$modelo'";
                $resultado2=mysqli_query($conexion,$op);
                $row2=mysqli_fetch_array($resultado2);
                 $precio=$row2['precio'];
                 $id_almacen=$row2['id_almacen'];
            
                
                 $op="SELECT * FROM almacen WHERE id='$id_almacen'";
                $resultado2=mysqli_query($conexion,$op);
                $row2=mysqli_fetch_array($resultado);
                $capital=$row2['capital']-$precio;
                $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
                mysqli_query($conexion,$op);
                 $op="UPDATE pieza SET en_almacen='0' WHERE id='$fecha'";
                mysqli_query($conexion,$op);
                
                
            }
            
            
           
            
            
            
        }        
        
        header("location:../paginas/pieza_venta.php");
    }else if(strcmp($pagina,"pieza")==0){
        $tipo_elim=$_POST['tipo-elim'];
        if(strcmp($tipo_elim,"unico-id")==0){
            $id=$_POST['id-elim'];
            $op="SELECT * FROM pieza WHERE id='$id'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $nombre=$row['nombre'];
            $modelo=$row['modelo'];
            $op="SELECT * FROM pieza p JOIN catalogo_pieza c ON c.nombre='$nombre' AND c.modelo='$modelo'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $precio=$row['precio'];
            $id_almacen=$row['id_almacen'];
            
            $op="SELECT * FROM almacen WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $capital=$row['capital']-$precio;
            $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            
            
            $op="UPDATE producto SET en_almacen='0' WHERE no_serie='$no_serie'";
            mysqli_query($conexion,$op);
            
            
        }else{
            $fecha=$_POST['fecha'];
        
            $op="SELECT pieza.id FROM pieza JOIN compras ON pieza.id_compras=compras.id AND compras.fecha='$fecha'";
            $resultado=mysqli_query($conexion,$op);
            
            while($row=mysqli_fetch_array($resultado)){
                $id=$nombre=$row['id'];    
                $nombre=$row['nombre'];
                $modelo=$row['modelo'];
                $op="SELECT * FROM pieza p JOIN catalogo_pieza c ON c.nombre='$nombre' AND c.modelo='$modelo'";
                $resultado2=mysqli_query($conexion,$op);
                $row2=mysqli_fetch_array($resultado2);
                 $precio=$row2['precio'];
                 $id_almacen=$row2['id_almacen'];
            
                
                 $op="SELECT * FROM almacen WHERE id='$id_almacen'";
                $resultado2=mysqli_query($conexion,$op);
                $row2=mysqli_fetch_array($resultado);
                $capital=$row2['capital']-$precio;
                $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
                mysqli_query($conexion,$op);
                 $op="UPDATE pieza SET en_almacen='0' WHERE id='$fecha'";
                mysqli_query($conexion,$op);
                
                
            }
            
            
           
            
            
            
        }        
        header("location:../paginas/piezas.php");
    }else if(strcmp($pagina,"producto")==0){
        $tipo_elim=$_POST['tipo-elim'];
        if(strcmp($tipo_elim,"unico-id")==0){
            $no_serie=$_POST['id-elim'];
            $op="SELECT * FROM producto WHERE no_serie='$no_serie'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $precio=$row['costo'];
            $id_almacen=$row['id_almacen'];
            
            $op="SELECT * FROM almacen WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $capital=$row['capital']-$precio;
            $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            
            
            $op="UPDATE producto SET en_almacen='0' WHERE no_serie='$no_serie'";
            mysqli_query($conexion,$op);
            
            
        }else{
            $fecha=$_POST['fecha'];
        
            $op="SELECT * FROM producto WHERE fecha='$fecha'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $precio=$row['costo'];
            $id_almacen=$row['id_almacen'];
            
            $op="SELECT * FROM almacen WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            $capital=$row['capital']-$precio;
            $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
            $resultado=mysqli_query($conexion,$op);
            
            
            
            
            $op="UPDATE producto SET en_almacen='0' WHERE fecha='$fecha'";
            mysqli_query($conexion,$op);
            
            
            
        }
        header("location:../paginas/productos.php");
    }else if(strcmp($pagina,"proveedores")==0){
        $rfc=$_POST['id-elim'];
        $op="UPDATE proveedores SET estatus='0' WHERE RFC='$rfc'";
        mysqli_query($conexion,$op);
        header("location:../paginas/proveedores.php");
    }else if(strcmp($pagina,"venta")==0){
        $tipo_elim=$_POST['tipo-elim'];
        if(strcmp($tipo_elim,"unico-id")==0){
            $id=$_POST['id-elim'];
            $op="DELETE FROM venta WHERE id='$id'";
            mysqli_query($conexion,$op);
        
            
        }else{
            $fecha=$_POST['fecha'];
        
            $op="DELETE FROM venta WHERE fecha='$fecha'";
            mysqli_query($conexion,$op);
            
            
            
        }
        header("location:../paginas/ventas.php");
    }
    mysqli_close($conexion);
?>

