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
        $id=$_POST['id'];
        
        $op="UPDATE compras SET fecha='$tiempo',RFC='$rfc' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        header('location:../paginas/compras.php');
        
    }else if(strcmp($pagina,"pieza")==0){
        $id=$_POST['id'];
        $id_new=$_POST['id_new'];
        //$idcompra=$_POST['idcompra'];
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
        $op="SELECT p.id,p.nombre,p.modelo,cp.precio,p.id_almacen,p.id_compras,al.nombre,al.capital FROM pieza p JOIN almacen al ON p.id_almacen=al.id JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE p.id='$id'";
        $resultado=mysqli_query($conexion,$op);
        $row = mysqli_fetch_array( $resultado );
        $precioPieza=$row['precio'];/*Recupero el precio de esa pieza*/
        $idal=$row['id_almacen'];/*Recupero el ID del almacen donde etaba esta pieza*/
        $idcomp=$row['id_compras'];/*Recupero el ID de la compra en la que estaba esta pieza*/
        /*-------------------------------------------------------------------------*/
        foreach($separada as $valor){
            if($band){
                $nombre=$valor;
                $band=false;
            }else{
                $modelo=$valor;
            }
        }
        /***************************NUEVO PARA ACTUALIZAR LA PIEZA***************************/
        //Recupero el capital que tengo en el almacen en el que estaba para quitarle el precio de esta
        $op="SELECT * FROM almacen WHERE id='$idal'";
        $consulta=mysqli_query($conexion,$op);
        $rowBD = mysqli_fetch_array( $consulta );
        $precioActuAlAnt=$rowBD['capital']-$precioPieza;
        
        $op="UPDATE almacen SET capital='$precioActuAlAnt' WHERE id='$idal'";
        $consulta=mysqli_query($conexion,$op);
        
        //Recupero el capital que tengo en el almacen en el que va a estar esta pieza y agregarle el precio en el capital
        $op="SELECT * FROM almacen WHERE id='$id_almacen'";
        $consulta=mysqli_query($conexion,$op);
        $rowBD = mysqli_fetch_array( $consulta );
        $precioActuAlDes=$rowBD['capital']+$precioPieza;
        
        $op="UPDATE almacen SET capital='$precioActuAlDes' WHERE id='$id_almacen'";
        $consulta=mysqli_query($conexion,$op);
        
        /*
        //Recuperar el el precio de la compra en la que estaba esta pieza
        $op="SELECT * FROM compras WHERE id='$idcomp'";
        $consulta=mysqli_query($conexion,$op);
        $rowBD = mysqli_fetch_array( $consulta );
        $precioCompAnt=$rowBD['precio']-$precioPieza;
        
        $op="UPDATE compras SET precio='$precioCompAnt' WHERE id='$idcomp'";
        $consulta=mysqli_query($conexion,$op);
        
          
        //Recuperar el precio de la compra en la que va estar esta pieza
        $op="SELECT * FROM compras WHERE id='$id_compras'";
        $consulta=mysqli_query($conexion,$op);
        $rowBD = mysqli_fetch_array( $consulta );
        $precioCompDes=$rowBD['precio']+$precioPieza;
        
        $op="UPDATE compras SET precio='$precioCompDes' WHERE id='$id_compras'";
        $consulta=mysqli_query($conexion,$op);
        */
        //+++++++++++++++++++++++++++++++++++++++++++++++++
        /***************************NUEVO PARA ACTUALIZAR LA PIEZA***************************/
        //Actualizamos los datos de la pieza
        $op="UPDATE pieza SET id='$id_new', descripcion='$descripcion', id_almacen='$id_almacen', nombre='$nombre', modelo='$modelo' WHERE id='$id'";
        mysqli_query($conexion,$op);
        /*--------------------------------------------------------------------------*/
        
        
        
        /*actualizar el precio de la compra de la compra donde se saco esta pieza*/
        /*$op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE c.id='$idcomp' AND p.en_almacen=1";
        $resultado=mysqli_query($conexion,$op);
        $num_reg=mysqli_num_rows($resultado);
        
        
        $precio=0;
        if($num_reg > 0){
            
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
                $precio=$precio+$row['precio']; /*precios detodaslas piezas en almacen para calcular el precio de compra*/
          /*  }
        }
        
        $op="UPDATE compras SET precio='$precio' WHERE id='$idcomp'";/*Se actualizo el precio de la compra de la compra donde estaba la pieza*/
       /* mysqli_query($conexion,$op);
        
        /*--------------------------------------------------------------------------*/
        //Actualizar el capital del almacen en el que fue sacado la pieza
        
        /*$op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE p.id_almacen='$idal' AND p.en_almacen=1";
        $resultado=mysqli_query($conexion,$op);
        $num_reg=mysqli_num_rows($resultado);
        
        $capital=0;
        if($num_reg > 0){
            
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
                $capital=$capital+$row['precio']; /*precios detodaslas piezas en almacen para calcular el el capital del almacen*/
           /* }
        }
        
        $op="UPDATE almacen SET capital='$capital' WHERE id='$idal'";/*Actualizo el capital del almacen anterior*/
        /*mysqli_query($conexion,$op);
        
        /*-----------------------------------------------------------------------------------------*/
        /*Se actualiza la cantidad de productos de la compra anterior*/
        
        /*$op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE c.id='$idcomp'";
        $resultado=mysqli_query($conexion,$op);
        $num_regC=mysqli_num_rows($resultado);
        
        $op="UPDATE compras SET cantidad='$num_regC' WHERE id='$id_compras'";
        mysqli_query($conexion,$op);
        
        /*------------------------------------------------------------------------------------------*/
        /*-----------------------------------------------------------------------------------*/
  
       /*Para sacar la cantidad de productos y el precio de la compra y si esta pieza esta en elmacen*/
        /*$op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE c.id='$id_compras' AND p.en_almacen=1";
        $resultado=mysqli_query($conexion,$op);
        $num_reg=mysqli_num_rows($resultado);
        
        
        $precio=0;
        if($num_reg > 0){
            
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
                $precio=$precio+$row['precio']; /*precios detodaslas piezas en almacen para calcular el precio de compra*/
           /* }
        }
        
        /*$op="UPDATE compras SET precio='$precio' WHERE id='$id_compras'";
        mysqli_query($conexion,$op);
        
        $op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE p.id_almacen='$id_almacen' AND p.en_almacen=1";
        $resultado=mysqli_query($conexion,$op);
        $num_reg=mysqli_num_rows($resultado);
        
        $capital=0;
        if($num_reg > 0){
            
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
                $capital=$capital+$row['precio']; /*precios detodaslas piezas en almacen para calcular el el capital del almacen*/
            /*}
        }
        
        $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
        mysqli_query($conexion,$op);
        
        
        /*Se actualiza el numero de compras de ese id de compras*/
        /*$op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE c.id='$id_compras'";
        $resultado=mysqli_query($conexion,$op);
        $num_regC=mysqli_num_rows($resultado);
        
        $op="UPDATE compras SET cantidad='$num_regC' WHERE id='$id_compras'";
        mysqli_query($conexion,$op);
        
        /*libera la memoria*/
        mysqli_free_result( $consulta );
        
        header('location:../paginas/piezas.php');
        
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
        $id=$_POST['id'];
        
        $op="UPDATE almacen SET nombre='$almacen', descripcion='$descripcion' WHERE id='$id'";
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
        
        /*---------------------------------------------------------------------------------*/
        //Actualizar el precio de la compra de la tabla catalogo_pieza
       $op="UPDATE catalogo_pieza SET precio='$precio_compra' WHERE nombre='$nombre' AND modelo='$modelo'";
        mysqli_query($conexion,$op);
    
        /*------------------------------------------------------------------------------------*/
        
        
        
        
        
        /*ACTUALIZAR EL CAPITAL DE ALMACEN Y EL PRECIO DE LA COMPRA*/
    /*    $op="SELECT * FROM compras";
        $resultado=mysqli_query($conexion,$op);
        $num_regComp=mysqli_num_rows($resultado);/*Cuantos registros tenemos en compras*/
        
        
   /*     if($num_regComp > 0){
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
                $id_compras=$row['id'];
                $op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE c.id='$id_compras' AND p.en_almacen=1";
                $consulta=mysqli_query($conexion,$op);
                $precio=0;
                 while($reg = mysqli_fetch_array( $consulta ) ){
                     $precio=$precio+$reg['precio']; /*precios detodaslas piezas en almacen para calcular el precio de compra*/
    /*             }
                echo "<br><br>Total en la compra = ".$precio;
            }
        }
        /*
        $op="SELECT * FROM almacen";
        $resultado=mysqli_query($conexion,$op);
        $num_regAl=mysqli_num_rows($resultado);/*Cuantos registros tenemos en almacen*/
        
        
        
        /*$op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE c.id='$id_compras' AND p.en_almacen=1";
        $resultado=mysqli_query($conexion,$op);
        $num_reg=mysqli_num_rows($resultado);
        
        
        $precio=0;
        if($num_reg > 0){
            
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
                $precio=$precio+$row['precio']; /*precios detodaslas piezas en almacen para calcular el precio de compra*/
            /*}
        }
        
        /*$op="UPDATE compras SET precio='$precio' WHERE id='$id_compras'";
        mysqli_query($conexion,$op);
        
        $op="SELECT p.id, p.nombre, p.modelo, cp.precio,c.id'id_compra', p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN catalogo_pieza CP ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE p.id_almacen='$id_almacen' AND p.en_almacen=1";
        $resultado=mysqli_query($conexion,$op);
        $num_reg=mysqli_num_rows($resultado);
        
        $capital=0;
        if($num_reg > 0){
            
            //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
            while($row = mysqli_fetch_array( $resultado ) ){
                $capital=$capital+$row['precio']; /*precios detodaslas piezas en almacen para calcular el el capital del almacen*/
           /* }
        }
        
        $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
        mysqli_query($conexion,$op);
        /*----------------------------------------------------------------------------------------*/
        
        /*libera la memoria*/
        /*mysqli_free_result( $resultado );*/
        
        header('location:../paginas/catalogo_piezas.php');
        
    }else if(strcmp($pagina,"pieza_venta")==0){
        $id=$_POST['id'];
        $precio=$_POST['precio'];
        $op="UPDATE pieza_venta SET precio_publico='$precio' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        
        header('location:../paginas/pieza_venta.php');
        
    }

    mysqli_close($conexion);

?>