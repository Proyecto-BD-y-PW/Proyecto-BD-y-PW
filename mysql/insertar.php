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
          
        $op="SELECT * FROM catalogo_pieza ORDER BY nombre,modelo ASC";
        $resultado=mysqli_query($conexion,$op);
        $nombre_pieza="";
        $modelo_pieza="";
        $band=true;
        $i=1;
        /*parte donde llenamos la tabla pieza_modelo para saber que piezas lleva este modelo*/
        while($row=mysqli_fetch_array($resultado)){
            $nombre_pieza=$row['nombre'];
            $modelo_pieza=$row['modelo'];
            /*usamos un contador ya que en el name de los checkbox comenzamos desde 1 para nombrarlos, esto debido a que los ordenamos de manera ASC para que siempre salgan en este orden*/
            if(isset($_POST[$i])){
                $op="INSERT INTO pieza_modelo (nombre_modelo,nombre_pieza,modelo_pieza) VALUES('$nombre','$nombre_pieza','$modelo_pieza')";
                mysqli_query($conexion,$op);
                
            }
            $i++;
        }  
        
         header('location:../paginas/modelo.php');
       
    }else if(strcmp($pagina,"arquitectura")==0){
        $tipo=$_POST['tipo'];
        $op="INSERT INTO arquitectura(tipo,estatus) VALUES ('$tipo',1)";
        mysqli_query($conexion,$op);
        header('location:../paginas/arquitecturas.php'); 
        
    }else if(strcmp($pagina,"cliente")==0){
        $rfc=$_POST['rfc'];
        $nombre=$_POST['nombre'];
        $telefono=$_POST['telefono'];
        $correo=$_POST['correo'];
        $op="INSERT INTO cliente(RFC,nombre,telefono,email) VALUES ('$rfc','$nombre','$telefono','$correo')";
        mysqli_query($conexion,$op);
        
        header('location:../paginas/clientes.php');
        
    }else if(strcmp($pagina,"compra")==0){
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];
        $tiempo=date('Y-m-d H:i:s', strtotime("$fecha $hora"));
        $rfc=$_POST['rfc_proveedor'];
        
        
        $op="INSERT INTO compras(fecha,cantidad,precio,estatus,RFC) VALUES ('$tiempo','0','0','1','$rfc')";
        mysqli_query($conexion,$op);
        
        header('location:../paginas/compras.php');
        
    }else if(strcmp($pagina,"pieza")==0){
        $id=$_POST['id'];
        $id_almacen=$_POST['idalmacen'];
        $id_compras=$_POST['idcompras'];
        
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];
        $descripcion=$_POST['descripcion'];
        $tiempo=date('Y-m-d H:i:s', strtotime("$fecha $hora"));
       
        
        $nombremodelo=$_POST['nombremodelo'];
        $band=true;
        $nombre="";
        $modelo="";
        $separada=explode("*",$nombremodelo);
        $tama??o=sizeof($separada);
        foreach($separada as $valor){
            if($band){
                $nombre=$valor;
                $band=false;
            }else{
                $modelo=$valor;
            }
        }
        $op="INSERT INTO pieza (id,en_almacen,tipo,descripcion,id_compras,id_almacen,nombre,modelo)
         VALUES('$id','1','','$descripcion','$id_compras','$id_almacen','$nombre','$modelo')";
        mysqli_query($conexion,$op);
        
        
        
        //Agrego el precio de la pieza a la compra
        $op=" SELECT p.id, p.nombre,p.modelo,cp.precio FROM pieza p JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE p.id='$id'";
        $resultado=mysqli_query($conexion,$op);
        $rowBD = mysqli_fetch_array( $resultado );
        
        $op="SELECT * FROM compras WHERE id='$id_compras'";
        $resultado=mysqli_query($conexion,$op);
        $row = mysqli_fetch_array( $resultado );
        $precioComp=$row['precio']+$rowBD['precio'];/*Precio de de lo que se lleba en compras m??s el precio de la pieza*/
     
        
        $op="SELECT * FROM catalogo_pieza WHERE nombre='$nombre' AND modelo='$modelo'";   
        $result=mysqli_query($conexion,$op);
        $row_catalogo=mysqli_fetch_array($result);
        $precio=$row_catalogo['precio'];
        
        $op="SELECT * FROM almacen WHERE id='$id_almacen'";   
        $result=mysqli_query($conexion,$op);
        $row_almacen=mysqli_fetch_array($result);
        $capital=$row_almacen['capital']+$precio;
        
        
        $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
        mysqli_query($conexion,$op);
        
        
        /*Se actualiza el numero de compras de ese id de compras*/
        $op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE c.id='$id_compras'";
        $resultado=mysqli_query($conexion,$op);
        $num_regC=mysqli_num_rows($resultado);
        
        $op="UPDATE compras SET cantidad='$num_regC', precio='$precioComp' WHERE id='$id_compras'";
        mysqli_query($conexion,$op);
        
        /*libera la memoria*/
        mysqli_free_result( $resultado );
        
        header('location:../paginas/piezas.php');
        
    }else if(strcmp($pagina,"producto")==0){
        $noserie=$_POST['nserie'];
        $descripcion=$_POST['descripcion'];
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];
        $tiempo=date('Y-m-d H:i:s', strtotime("$fecha $hora"));
        $costo=$_POST['costo'];
        $id_almacen=$_POST['idalmacen'];
        $nombre_modelo=$_POST['modelo'];
        
        $op="INSERT INTO producto(no_serie,en_almacen,descripcion,fecha,costo,id_almacen,nombre_modelo) VALUES ('$noserie','1','$descripcion','$tiempo','$costo','$id_almacen','$nombre_modelo')";
        mysqli_query($conexion,$op);
        
        
        $op="SELECT * FROM almacen WHERE id='$id_almacen'";
        $result=mysqli_query($conexion,$op);
        $row3=mysqli_fetch_array($result);
        $precio=$row3['capital']+$costo;
        $op="UPDATE almacen SET capital='$precio' WHERE id='$id_almacen'";
        mysqli_query($conexion,$op);
        
        
         $op="SELECT DISTINCT p.nombre,p.modelo FROM pieza p JOIN pieza_modelo pm ON p.nombre=pm.nombre_pieza AND p.modelo=pm.modelo_pieza WHERE pm.nombre_modelo='$nombre_modelo'";
         $resultado=mysqli_query($conexion,$op);
          while($row2=mysqli_fetch_array($resultado)){
            $nombre_pieza=$row2['nombre'];
            $nombre_modelo=$row2['modelo'];
             $op="SELECT * FROM pieza p JOIN catalogo_pieza ca ON p.nombre=ca.nombre AND p.modelo=ca.modelo WHERE p.nombre='$nombre_pieza' AND p.modelo='$nombre_modelo' AND p.en_almacen='1'";
            $resultado2=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado2);  
            $id_pieza=$row['id']; 
             
            $precio=$row['precio']; 
            $id_almacen=$row['id_almacen'];  
            $op="INSERT INTO pieza_armado(id,fecha) VALUES('$id_pieza','$tiempo')";
            mysqli_query($conexion,$op);
            $op="UPDATE pieza SET en_almacen='0',tipo='armado' WHERE id='$id_pieza'";
            mysqli_query($conexion,$op);
             
            $op="SELECT * FROM almacen WHERE id='$id_almacen'";
         
            $resultado2=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado2);
            echo $row['capital'];
            $capital=$row['capital']-$precio;
              
             $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
             mysqli_query($conexion,$op);
               
              
              
            
        }
        
        

        header('location:../paginas/productos.php');
    }else if(strcmp($pagina,"proveedor")==0){
        /*ya esta por parte de juca*/

        $RFC=$_POST['rfc'];
        $empresa=$_POST['empresa'];
        $nombre=$_POST['nproveedor'];
        $descripcion=$_POST['descripcion'];
        $telefono=$_POST['telefono'];
        $email=$_POST['correo'];


        $op="INSERT INTO proveedores (RFC,empresa,nombre_proveedor,descripcion,telefono,email,estatus)VALUES ('$RFC','$empresa','$nombre','$descripcion','$telefono','$email','1')";
        mysqli_query($conexion,$op);
        header('location:../paginas/proveedores.php');


    }else if(strcmp($pagina,"venta")==0){
        $rfc=$_POST['rfc'];
        $idempleado=$_POST['idempleado'];
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];
        $tiempo=date('Y-m-d H:i:s', strtotime("$fecha $hora"));
        
        $op="INSERT INTO venta(fecha,cantidad,total,estatus,id_empleado,RFC_cliente) VALUES ('$tiempo','0','0','0','$idempleado','$rfc')";
        mysqli_query($conexion,$op);
        $idventa=mysqli_insert_id($conexion);
         $op="SELECT * FROM pieza_venta";
        $resultado=mysqli_query($conexion,$op);
        
        while($row=mysqli_fetch_array($resultado)){
            $id_pieza=$row['id'];
            if(isset($_POST[$id_pieza])){
            
                $op="INSERT INTO venta_pieza(id_venta,id_pieza) VALUES ('$idventa','$id_pieza')";
                mysqli_query($conexion,$op);
                $op="UPDATE pieza SET en_almacen=0 WHERE id='$id_pieza'";
                mysqli_query($conexion,$op);
                $op="SELECT * from venta WHERE id='$idventa'";
                $result=mysqli_query($conexion,$op);
                $ventarow=mysqli_fetch_array($result);
                $cantidad=$ventarow['cantidad'];
                $cantidad=$cantidad+1;
                $precio=$ventarow['total'];
                $precio=$precio+$row['precio_publico'];
                
                $op="UPDATE venta SET cantidad='$cantidad' WHERE id='$idventa'";
                $result=mysqli_query($conexion,$op);
                 $op="UPDATE venta SET total='$precio' WHERE id='$idventa'";
               $result=mysqli_query($conexion,$op);
                
                
                /*actualizamos capital del almacen*/
               
                $op="SELECT ca.precio 'precio_catalogo',p.id_almacen FROM pieza p JOIN catalogo_pieza ca ON p.modelo=ca.modelo AND p.nombre=ca.nombre WHERE p.id='$id_pieza'";
                $result=mysqli_query($conexion,$op);
                $row3=mysqli_fetch_array($result);
                $precio=$row3['precio_catalogo'];
                 $id_almacen=$row3['id_almacen'];
                
                 $op="SELECT * FROM almacen WHERE id='$id_almacen'";
                $result=mysqli_query($conexion,$op);
                $row3=mysqli_fetch_array($result);
                $precio=$row3['capital']-$precio;
                $op="UPDATE almacen SET capital='$precio' WHERE id='$id_almacen'";
                mysqli_query($conexion,$op);
                
                
            }
        }
       $op="SELECT * FROM producto";
        $resultado=mysqli_query($conexion,$op);
        
        while($row=mysqli_fetch_array($resultado)){
            $no_serie=$row['no_serie'];
            if(isset($_POST[$no_serie])){
            
                $op="INSERT INTO venta_producto(no_serie,id_venta) VALUES ('$no_serie','$idventa')";
                mysqli_query($conexion,$op);
                $op="UPDATE producto SET en_almacen=0 WHERE no_serie='$no_serie'";
                mysqli_query($conexion,$op);
                $op="SELECT * from venta WHERE id='$idventa'";
                $result=mysqli_query($conexion,$op);
                $ventarow=mysqli_fetch_array($result);
                $cantidad=$ventarow['cantidad'];
                $cantidad=$cantidad+1;
                $precio=$ventarow['total'];
                $precio=$precio+$row['costo'];
                
                $op="UPDATE venta SET cantidad='$cantidad' WHERE id='$idventa'";
                $result=mysqli_query($conexion,$op);
                 $op="UPDATE venta SET total='$precio' WHERE id='$idventa'";
               $result=mysqli_query($conexion,$op);
                
                /*actualizamos capital del almacen*/
                $op="SELECT * FROM producto WHERE no_serie='$no_serie'";
                $result=mysqli_query($conexion,$op);
                $row3=mysqli_fetch_array($result);
                
                $precio=$row3['costo'];
                $id_almacen=$row3['id_almacen'];
                $op="SELECT * FROM almacen WHERE id='$id_almacen'";
                $result=mysqli_query($conexion,$op);
                $row3=mysqli_fetch_array($result);
                $precio=$row3['capital']-$precio;
                 $op="UPDATE almacen SET capital='$precio' WHERE id='$id_almacen'";
                mysqli_query($conexion,$op);
                
                
                
            }
        }     
        
        
        
        header('location:../paginas/ventas.php');
    }else if(strcmp($pagina,"almacen")==0){
        $almacen=$_POST['n-almacen'];
        $descripcion=$_POST['descripcion'];
        
        $op="INSERT INTO almacen(nombre,descripcion,capital) VALUES ('$almacen','$descripcion',0)";
        mysqli_query($conexion,$op);
        
        header('location:../paginas/almacen.php');
    }else if(strcmp($pagina,"empleado")==0){
        $nombre=$_POST['nombre'];
        $telefono=$_POST['telefono'];
        $correo=$_POST['correo'];
        
        $op="INSERT INTO empleado(nombre,estatus,telefono,correo) VALUES ('$nombre','1','$telefono','$correo')";
        mysqli_query($conexion,$op);
        
        header('location:../paginas/empleados.php');
    }else if(strcmp($pagina,"catalogo_pieza")==0){
         $nombre=$_POST['nombre'];
        $modelo=$_POST['modelo'];
        $precio_compra=$_POST['precio_compra'];
        
        $op="INSERT INTO catalogo_pieza(nombre,modelo,precio) VALUES ('$nombre','$modelo','$precio_compra')";
        mysqli_query($conexion,$op);
        
        header('location:../paginas/catalogo_piezas.php');
        
    }else if(strcmp($pagina,"pieza_armado")==0){
        $id=$_POST['id-pieza'];
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];
        $tiempo=date('Y-m-d H:i:s', strtotime("$fecha $hora"));
       
        $op="INSERT INTO pieza_armado(id,fecha) VALUES ('$id','$tiempo')";
        mysqli_query($conexion,$op);
        $op="UPDATE pieza SET tipo='armado' WHERE id='$id'";
        mysqli_query($conexion,$op);
         $op="UPDATE pieza SET en_almacen='0' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        $op="SELECT * FROM pieza p JOIN catalogo_pieza ca ON p.nombre=ca.nombre AND p.modelo=ca.modelo WHERE p.id='$id'";
        $result=mysqli_query($conexion,$op);
                
        $row3=mysqli_fetch_array($result);
                
        $precio=$row3['precio'];
        $id_almacen=$row3['id_almacen'];
        $op="SELECT * FROM almacen WHERE id='$id_almacen'";
        $result=mysqli_query($conexion,$op);
        $row3=mysqli_fetch_array($result);
        $precio=$row3['capital']-$precio;
         $op="UPDATE almacen SET capital='$precio' WHERE id='$id_almacen'";
        mysqli_query($conexion,$op);
                
        
        
        header('location:../paginas/pieza_armado.php');
        
    }else if(strcmp($pagina,"pieza_venta")==0){
        $id=$_POST['id-pieza'];
        $precio=$_POST['precio'];
        $op="INSERT INTO pieza_venta(id,precio_publico) VALUES ('$id','$precio')";
        mysqli_query($conexion,$op);
        $op="UPDATE pieza SET tipo='venta' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        
        header('location:../paginas/pieza_venta.php');
        
    }

    mysqli_close($conexion);

?>