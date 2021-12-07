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
        $idnombre=$_POST['idnombre'];
        $id_arquitectura=$_POST['id-arquitectura'];
        $estatus=$_POST['estatus'];
        
        $op="UPDATE modelo SET nombre='$nombre', estatus='$estatus', id_arquitectura= '$id_arquitectura' WHERE nombre='$idnombre'";
        /*$op="INSERT INTO modelo(nombre,estatus,id_arquitectura) VALUES ('$nombre',1,'$id_arquitectura')";*/
        mysqli_query($conexion,$op);
        
        $op="SELECT * FROM catalogo_pieza";
        $resultado=mysqli_query($conexion,$op);
        $nombre_pieza="";
        $modelo_pieza="";
        $band=true;
        $separada=explode("*",$nombremodelo);
        $tamaño=sizeof($separada);
        
        while($row=mysqli_fetch_array($resultado)){
            $nombre_pieza=$row['nombre'];
            $modelo_pieza=$row['modelo'];
            if(isset($_POST[$nombre."*".$modelo])){
                $op="INSERT INTO pieza_modelo (nombre_modelo,nombre_pieza,modelo_pieza) VALUES('$nombre','$nombre_pieza','$modelo_pieza')";
                
            }
        } 
        
        header('location:../paginas/modelo.php');
        
        
    }else if(strcmp($pagina,"arquitectura")==0){
        $tipo=$_POST['tipo'];
        $estatus=$_POST['estatus'];
        $id=$_POST['id'];
        $op="UPDATE arquitectura SET tipo='$tipo', estatus='$estatus' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        header('location:../paginas/arquitecturas.php'); 
        
    }else if(strcmp($pagina,"cliente")==0){
        $rfc=$_POST['rfc'];
        $rfccamb=$_POST['rfccamb'];
        $nombre=$_POST['nombre'];
        $telefono=$_POST['telefono'];
        $correo=$_POST['correo'];
        $op="UPDATE cliente SET nombre='$nombre',telefono='$telefono',email='$correo', RFC='$rfccamb' WHERE RFC='$rfc'";
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
        $idcompra=$_POST['idcompra'];
        $id_almacen=$_POST['idalmacen'];
        $id_compras=$_POST['idcompras'];
        
        
        $descripcion=$_POST['descripcion'];
       
        
        $nombremodelo=$_POST['nombremodelo'];
        $band=true;
        $nombre="";
        $modelo="";
        $separada=explode("*",$nombremodelo);
        $tamaño=sizeof($separada);
        
        /*Actualizar los datos que tienen atributos calculados de otras tablas para eso primero toms mos algnos datos de lo que tiene la base de datos*/
        $op="SELECT p.id,p.nombre,p.modelo,cp.precio,p.id_almacen,al.nombre,al.capital FROM pieza p JOIN almacen al ON p.id_almacen=al.id JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE p.id='$id'";
        $resultado=mysqli_query($conexion,$op);
        $row = mysqli_fetch_array( $resultado );
        $precioPieza=$row['precio'];/*Recupero el precio de esa pieza*/
        $idal=$row['id_almacen'];/*Recupero el ID del almacen donde etaba esta pieza*/
        /*-------------------------------------------------------------------------*/
        
        $op="UPDATE pieza SET id='$id', descripcion='$descripcion', id_compras='$id_compras', id_almacen='$id_almacen', nombre=$nombre, modelo='$modelo'";
        mysqli_query($conexion,$op);
        
        
        $op="SELECT * FROM almacen WHERE id='$idal'";
        mysqli_query($conexion,$op);
        $resultado=mysqli_query($conexion,$op);
        $rowAl = mysqli_fetch_array( $resultado );
        $capitalActua=$rowAl['capital']-$precioPieza;
        
        $op="UPDATE almacen SET capital='$capitalActua' WHERE id='$idal'";/*Actualizo el capital de ese almacen para no tnerlo doble*/
        mysqli_query($conexion,$op);
        
        $op="SELECT * FROM compras WHERE id='$idcompra'";
        $resultado=mysqli_query($conexion,$op);
        $row = mysqli_fetch_array( $resultado );
        $cantidad=$row['cantidad']-1;
        $preciocompra=$row['precio']-$precioPieza;
        /*libera la memoria*/
        mysqli_free_result( $resultado );
        
        $op="UPDATE compras SET cantidad='$cantidad', precio='$preciocompra' WHERE id='$idcompra'";/*Le quito esta pieza a la cantida de compras asi como disminuir el costo de esa compra en su precio*/
        mysqli_query($conexion,$op);
     
        
        /*-----------------------------------------------------------------------------------*/
        
        foreach($separada as $valor){
            if($band){
                $nombre=$valor;
                $band=false;
            }else{
                $modelo=$valor;
            }
        }
       

        
        /*Para sacar la cantidad de productos y el precio de la compra y si esta pieza esta en elmacen*/
        $op='SELECT p.id, p.nombre, p.modelo, cp.precio,c.id"id_compra", p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo';
        $resultado=mysqli_query($conexion,$op);
        $num_reg=mysqli_num_rows($resultado);
        
        /*PROBAR SU FUNCIONALIDAD*/
        if($num_reg > 0){
            $precio=0;
            
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
              if($row['id_compra']==$id_compras && $row['en_almacen']==true){
                  $precio=$precio+$row['precio'];
              }  
            }
        }
        
        $op="UPDATE compras SET precio='$precio' WHERE id='$id_compras'";
        mysqli_query($conexion,$op);
        
        /*libera la memoria*/
        mysqli_free_result( $resultado );
        
        $op="SELECT * FROM compras WHERE id='$id_compras'";
        $resultado=mysqli_query($conexion,$op);
        $row = mysqli_fetch_array( $resultado );
        $cantidad=$row['cantidad']+1;
        $precioTot=$row['precio'];
        
        $op="SELECT * FROM almacen WHERE id='$id_almacen'";/*Actualizar el capital del almacen*/
        $resultado=mysqli_query($conexion,$op);
        $arrayAl=mysqli_fetch_array( $resultado );
        $capital=$precioTot+$arrayAl['capital'];
        
        $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
        mysqli_query($conexion,$op);
        
        /*libera la memoria*/
        mysqli_free_result( $resultado );
        
        /*Se actualiza el numero de compras de ese id de compras*/
        $op="UPDATE compras SET cantidad='$cantidad' WHERE id='$id_compras'";
        mysqli_query($conexion,$op);
        
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
        

        header('location:../paginas/productos.php');
    }else if(strcmp($pagina,"proveedor")==0){

        $RFC=$_POST['rfc'];
        $rfccamb=$_POST['rfccamb'];
        $empresa=$_POST['empresa'];
        $nombre=$_POST['nproveedor'];
        $descripcion=$_POST['descripcion'];
        $telefono=$_POST['telefono'];
        $email=$_POST['correo'];
        $estatus=$_POST['estatus'];

        $op="UPDATE proveedores SET empresa='$empresa',nombre_proveedor='$nombre',descripcion='$descripcion',telefono='$telefono',email='$email',estatus='$estatus', RFC='$rfccamb' WHERE RFC='$RFC'";
        mysqli_query($conexion,$op);
        header('location:../paginas/proveedores.php');


    }else if(strcmp($pagina,"venta")==0){
        $idventa=$_POST['id'];
        $rfc=$_POST['rfc'];
        $estatus=$_POST['estatus'];
        $idempleado=$_POST['idempleado'];
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];
        $tiempo=date('Y-m-d H:i:s', strtotime("$fecha $hora"));
        
        $op="UPDATE venta SET fecha='$tiempo',estatus='$estatus',id_empleado='$idempleado',RFC_cliente='$rfc' WHERE id='$idventa'";
        mysqli_query($conexion,$op);
        
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
        $estatus=$_POST['estatus'];
        $id=$_POST['id'];
        
        $op="UPDATE empleado SET nombre='$nombre',estatus='$estatus',telefono='$telefono',correo='$correo' WHERE id='$id'";
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