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
         mysqli_query($conexion,$op);
        
    
        
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
        $id_almacen=$_POST['idalmacen'];
        $id_compras=$_POST['idcompras'];
        
        
        $descripcion=$_POST['descripcion'];
       
        
        /*$nombremodelo=$_POST['nombremodelo'];
        $band=true;
        $nombre="";
        $modelo="";
        $separada=explode("*",$nombremodelo);
        $tamaño=sizeof($separada);
        foreach($separada as $valor){
            if($band){
                $nombre=$valor;
                $band=false;
            }else{
                $modelo=$valor;
            }
        }*/
        /*Actualizar los datos que tienen atributos calculados de otras tablas para eso primero toms mos algnos datos de lo que tiene la base de datos*/
        $op="SELECT p.id,p.nombre,p.modelo,cp.precio,p.id_almacen,p.id_compras,al.nombre,al.capital FROM pieza p JOIN almacen al ON p.id_almacen=al.id JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo WHERE p.id='$id' ";
        $resultado=mysqli_query($conexion,$op);
        $row = mysqli_fetch_array( $resultado );
        $precioPieza=$row['precio'];/*Recupero el precio de esa pieza*/
        $idal=$row['id_almacen'];/*Recupero el ID del almacen donde etaba esta pieza*/
        $idcomp=$row['id_compras'];/*Recupero el ID de la compra en la que estaba esta pieza*/
        /*-------------------------------------------------------------------------*/
       /* $op="SELECT * FROM catalogo_pieza WHERE nombre='$nombre' AND modelo='$modelo'";
        $result=mysqli_query($conexion,$op);
        $row=mysqli_fetch_array($result);*/
        $precio_nuevo=$precio_pieza;
        /***************************NUEVO PARA ACTUALIZAR LA PIEZA***************************/
        //Recupero el capital que tengo en el almacen en el que estaba para quitarle el precio de esta
        $op="SELECT * FROM almacen WHERE id='$idal'";
        $consulta=mysqli_query($conexion,$op);
        $rowBD = mysqli_fetch_array( $consulta );
        $precioActuAlAnt=$rowBD['capital']-$precioPieza;
        
        $op="UPDATE almacen SET capital='$precioActuAlAnt' WHERE id='$idal'";
        $consulta=mysqli_query($conexion,$op);
        
        $op="UPDATE pieza SET id='$id_new', descripcion='$descripcion', id_almacen='$id_almacen', nombre='$nombre', modelo='$modelo' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        
        //Recupero el capital que tengo en el almacen en el que va a estar esta pieza y agregarle el precio en el capital
        $op="SELECT * FROM almacen WHERE id='$id_almacen'";
        $consulta=mysqli_query($conexion,$op);
        $rowBD = mysqli_fetch_array( $consulta );
        $precioActuAlDes=$rowBD['capital']+$precio_nuevo;
        
        $op="UPDATE almacen SET capital='$precioActuAlDes' WHERE id='$id_almacen'";
        $consulta=mysqli_query($conexion,$op);
        
        
        
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
        
        
        
        $op="SELECT * FROM catalogo_pieza WHERE nombre='$nombre' AND modelo='$modelo'";
        $resultado=mysqli_query($conexion,$op);
        $row=mysqli_fetch_array($resultado);
        $precio_anterior=$row['precio'];
        $operacion="";
        $precio_nuevo=0;
        if($precio_compra>$precio_anterior){
            
            $precio_nuevo=$precio_compra-$precio_anterior;
            $operacion="suma";
        }else if($precio_compra<$precio_anterior){
            $precio_nuevo=$precio_anterior-$precio_compra;
            $operacion="resta";
        }else{
            $operacion="nada";
            $precio_nuevo=$precio_anterior;
        }
        /*---------------------------------------------------------------------------------*/
        //Actualizar el precio de la compra de la tabla catalogo_pieza
       $op="UPDATE catalogo_pieza SET precio='$precio_compra' WHERE nombre='$nombre' AND modelo='$modelo'";
        mysqli_query($conexion,$op);
    
        /*------------------------------------------------------------------------------------*/
        
        
        $op="SELECT * FROM catalogo_pieza ca JOIN pieza p ON ca.nombre=p.nombre AND ca.modelo=p.modelo JOIN almacen a ON p.id_almacen=a.id WHERE p.nombre='$nombre' AND p.modelo='$modelo'";
        $resultado=mysqli_query($conexion,$op);
        
        
        while($row=mysqli_fetch_array($resultado)){
            
            if($row['en_almacen']){
                
                $id_almacen=$row['id_almacen'];
                $op="SELECT * FROM almacen WHERE id='$id_almacen'";
                $resultado2=mysqli_query($conexion,$op);
                $row2=mysqli_fetch_array($resultado2);
                $capital=$row2['capital'];
                
                if($operacion=="suma"){
                    $capital+=$precio_nuevo;
                    $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
                    mysqli_query($conexion,$op);
                }else if($operacion=="resta"){
                    $capital-=$precio_nuevo;
                    $op="UPDATE almacen SET capital='$capital' WHERE id='$id_almacen'";
                    mysqli_query($conexion,$op);
               
                }else{
                    
                }
                
                
                
            }
            
            
        }
        
    
        
        header('location:../paginas/catalogo_piezas.php');
        
    }else if(strcmp($pagina,"pieza_venta")==0){
        $id=$_POST['id'];
        $precio=$_POST['precio'];
        $op="UPDATE pieza_venta SET precio_publico='$precio' WHERE id='$id'";
        mysqli_query($conexion,$op);
        
        
        header('location:../paginas/pieza_venta.php');
        
    }else if(strcmp($pagina,"perfil")==0){
        
        $nombre=$_POST['nombre'];
        $correo=$_POST['correo'];
        $privilegios=$_POST['privilegios'];
        $contrasena_an=$_POST['contrasena_antigua'];
        $contrasena_nue=$_POST['contrasena_nueva'];
        $op="SELECT * FROM usuario WHERE nombre='$nombre'";
        $resultado=mysqli_query($conexion,$op);
        $row=mysqli_fetch_array($resultado);
        if(password_verify($contrasena_an,$row['contrasena'])){
            $contrasena_nue=password_hash($contrasena_nue,PASSWORD_DEFAULT);
            $op="UPDATE mysql.user SET user='newusername',password=$contrasena_nue WHERE user='$usuario'";
            mysqli_query($conexion,$op);
            
            $op="FLUSH PRIVILEGES";
            mysqli_query($conexion,$op);
        
            $op="UPDATE usuario SET nombre='$nombre',correo='$correo',privilegios='$privilegios',contrasena='$contrasena_nue'";
            mysqli_query($conexion,$op);
            $op="FLUSH PRIVILEGES";
            mysqli_query($conexion,$op);
        }
        
        
        
    }

    mysqli_close($conexion);

?>