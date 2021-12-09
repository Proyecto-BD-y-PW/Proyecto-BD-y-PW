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
       </script>";
        die();
    }
    
  $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Pieza Venta</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link href="https://file.myfontastic.com/zmGVYTk8c485ktmePB4HkF/icons.css" rel="stylesheet">
    
</head>
<body>
    
    <!-- <main class="contenedor">
   -->     <input type="checkbox" name="" id="check" checked>

    <header class="site-header">
        
        <div class="site-elements">

            <div class="header-left">
                <label for="check"><i class="icon-desktop" id="sidebar_btn"></i></label>
                <h1>IGNITION<span> PC</span></h1>
                <!--
               --> 
            </div>
            <h1> <span>PIEZAS DE VENTA</span> </h1>
            <div class="header-right">
               <a href="../paginas/pieza_venta.php">
                    <button>REGRESAR</button>
                </a>
                <a href="../funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>
     <!--    <div class="table-mode">
     -->    <table id="tabla-consultas">
             <tr>
                 <th>ID</th>
                  <th>NOMBRE</th>
                 <th>MODELO</th>
                 <th>PRECIO DE COMPRA</th>
                  <th>PRECIO AL PUBLICO</th>
                  <th>DESCRIPCION</th>
                  <th>ESTATUS</th>
                 <th>ID DEL ALMACEN</th>
                 <th>NOMBRE DEL ALMACEN</th>
                 <th>RFC DEL PROVEEDOR</th>
                 <th>EMPRESA</th>
                 <th>FECHA DE COMPRA</th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT p.id,pv.precio_publico 'precio_publico',p.nombre,p.modelo,cp.precio,p.descripcion,p.en_almacen,p.id_almacen,a.nombre 'nombre_almacen',pr.RFC,pr.empresa,c.fecha FROM pieza_venta pv JOIN pieza p ON pv.id=p.id JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo JOIN almacen a ON p.id_almacen=a.id JOIN compras c ON p.id_compras=c.id JOIN proveedores pr ON pr.RFC=c.RFC";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){
                        $id=$row['id'];
                        $nombre=$row['nombre'];
                        $modelo=$row['modelo'];
                        $precio_publico=$row['precio_publico'];
                        $precio_compra=$row['precio'];
                        $descripcion=$row['descripcion'];
                        $estatus=$row['en_almacen'];
                        if($estatus){
                            $estatus="en almacen";
                        }else{
                            $estatus="vendida";
                        }
                        $id_almacen=$row['id_almacen'];
                        $nombre_almacen=$row['nombre_almacen'];
                        $rfc_proveedor=$row['RFC'];
                        $empresa=$row['empresa'];
                        $fecha=$row['fecha'];
                       
                        echo "<tr>
                                <td> $id </td>
                                 <td> $nombre </td>
                                <td> $modelo </td>
                                <td> $precio_compra </td>
                                <td> $precio_publico </td>
                                <td> $descripcion </td>
                                <td> $estatus </td>
                                <td> $id_almacen </td>
                                <td> $nombre_almacen </td>
                                 <td> $rfc_proveedor </td>
                                <td> $empresa </td>
                                <td> $fecha </td>
                        
                        
                            </tr>";
                        
                    }
                    
                }else if($tipo_cons=="unico-i"){
                    $id=$_POST['id-cons'];
                     $op="SELECT p.id,pv.precio_publico 'precio_publico',p.nombre,p.modelo,cp.precio,p.descripcion,p.en_almacen,p.id_almacen,a.nombre 'nombre_almacen',pr.RFC,pr.empresa,c.fecha FROM pieza_venta pv JOIN pieza p ON p.id=pv.id JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo JOIN almacen a ON p.id_almacen=a.id JOIN compras c ON p.id_compras=c.id JOIN proveedores pr ON pr.RFC=c.RFC WHERE p.id='$id'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                         $id=$row['id'];
                        $nombre=$row['nombre'];
                        $modelo=$row['modelo'];
                        $precio_publico=$row['precio_publico'];
                        $precio_compra=$row['precio'];
                        $descripcion=$row['descripcion'];
                        $estatus=$row['en_almacen'];
                        if($estatus){
                            $estatus="en almacen";
                        }else{
                            $estatus="vendida";
                        }
                        $id_almacen=$row['id_almacen'];
                        $nombre_almacen=$row['nombre_almacen'];
                        $rfc_proveedor=$row['RFC'];
                        $empresa=$row['empresa'];
                       $fecha=$row['fecha'];
                       
                        echo "<tr>
                                <td>  $id </td>
                                 <td> $nombre </td>
                                <td> $modelo </td>
                                <td> $precio_compra </td>
                                <td> $precio_publico </td>
                                <td> $descripcion </td>
                                <td> $estatus </td>
                                <td> $id_almacen </td>
                                <td> $nombre_almacen </td>
                                 <td> $rfc_proveedor </td>
                                <td> $empresa </td>
                                <td> $fecha </td>
                        
                        
                            </tr>";
                        
                    
                    
                    
                }else if($tipo_cons=="rango-fecha"){
                    $fecha_inicial=$_POST['fecha-ini'];
                    $fecha_final=$_POST['fecha-fin'];
                    
                     $op="SELECT p.id,pv.precio_publico 'precio_publico',p.nombre,p.modelo,cp.precio,p.descripcion,p.en_almacen,p.id_almacen,a.nombre 'nombre_almacen',pr.RFC,pr.empresa,c.fecha FROM pieza_venta pv JOIN pieza p ON p.id=pv.id JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo JOIN almacen a ON p.id_almacen=a.id JOIN compras c ON p.id_compras=c.id JOIN proveedores pr ON pr.RFC=c.RFC WHERE c.fecha BETWEEN '$fecha_inicial 00:00:00' AND '$fecha_final 23:59:59'";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){ 
                        $id=$row['id'];
                        $nombre=$row['nombre'];
                        $modelo=$row['modelo'];
                        $precio_publico=$row['precio_publico'];
                        $precio_compra=$row['precio'];
                        $descripcion=$row['descripcion'];
                        $estatus=$row['en_almacen'];
                        if($estatus){
                            $estatus="en almacen";
                        }else{
                            $estatus="vendida";
                        }
                        $id_almacen=$row['id_almacen'];
                        $nombre_almacen=$row['nombre_almacen'];
                        $rfc_proveedor=$row['RFC'];
                        $empresa=$row['empresa'];
                        $fecha=$row['fecha'];
                       
                        echo "<tr>
                                <td>  $id </td>
                                 <td> $nombre </td>
                                <td> $modelo </td>
                                <td> $precio_compra </td>
                                <td> $precio_publico </td>
                                <td> $descripcion </td>
                                <td> $estatus </td>
                                <td> $id_almacen </td>
                                <td> $nombre_almacen </td>
                                 <td> $rfc_proveedor </td>
                                <td> $empresa </td>
                                <td> $fecha </td>
                        
                        
                            </tr>";
                        }
                    
                }else{
                    $fecha=$_POST['fecha-cons'];
                    
                     $op="SELECT p.id,pv.precio_publico 'precio_publico',p.nombre,p.modelo,cp.precio,p.descripcion,p.en_almacen,p.id_almacen,a.nombre 'nombre_almacen',pr.RFC,pr.empresa,c.fecha FROM pieza_venta pv JOIN pieza p ON p.id=pv.id JOIN catalogo_pieza cp ON p.nombre=cp.nombre AND p.modelo=cp.modelo JOIN almacen a ON p.id_almacen=a.id JOIN compras c ON p.id_compras=c.id JOIN proveedores pr ON pr.RFC=c.RFC WHERE c.fecha='$fecha'";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){ 
                        $id=$row['id'];
                        $nombre=$row['nombre'];
                        $modelo=$row['modelo'];
                        $precio_publico=$row['precio_publico'];
                        $precio_compra=$row['precio'];
                        $descripcion=$row['descripcion'];
                        $estatus=$row['en_almacen'];
                        if($estatus){
                            $estatus="en almacen";
                        }else{
                            $estatus="vendida";
                        }
                        $id_almacen=$row['id_almacen'];
                        $nombre_almacen=$row['nombre_almacen'];
                        $rfc_proveedor=$row['RFC'];
                        $empresa=$row['empresa'];
                        $fecha=$row['fecha'];
                       
                        echo "<tr>
                                <td>  $id </td>
                                 <td> $nombre </td>
                                <td> $modelo </td>
                                <td> $precio_compra </td>
                                <td> $precio_publico </td>
                                <td> $descripcion </td>
                                <td> $estatus </td>
                                <td> $id_almacen </td>
                                <td> $nombre_almacen </td>
                                 <td> $rfc_proveedor </td>
                                <td> $empresa </td>
                                <td> $fecha </td>
                        
                        
                            </tr>";
                        }
                    
                }
                
                
             
             
             
             ?>
             
         </table>
         
         
       <!--  </div>
    </main>
       -->
    
   
</body>
</html>


<?php mysqli_close($conexion)?>