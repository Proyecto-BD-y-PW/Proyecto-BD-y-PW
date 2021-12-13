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
    <title>Consulta Venta</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link href="https://file.myfontastic.com/zmGVYTk8c485ktmePB4HkF/icons.css" rel="stylesheet">
    
</head>
<body>
    
        <input type="checkbox" name="" id="check" checked>

    <header class="site-header">
        
        <div class="site-elements">

            <div class="header-left">
                <label for="check"><i class="icon-desktop" id="sidebar_btn"></i></label>
                <h1>IGNITION<span> PC</span></h1>
 
            </div>
            <h1> <span>VENTAS</span> </h1>
            <div class="header-right">
               <a href="../paginas/ventas.php">
                    <button>REGRESAR</button>
                </a>
                <a href="../funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>
       <table id="tabla-consultas">
             <tr>
                 <th>ID</th>
                  <th>FECHA</th>
                 <th>CANTIDAD</th>
                 <th>TOTAL</th>
                 <th>ESTATUS</th>
                 <th>ID DEL VENDEDOR</th>
                  <th>NOMBRE DEL VENDEDOR</th>
                 <th>RFC CLIENTE</th>
                 <th>NOMBRE DEL CLIENTE</th>
                 <th>PIEZAS</th>
                 <th>PRODUCTOS</th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT *,v.estatus 'estatus_venta',v.id 'id_venta',e.nombre 'nombre_empleado',e.id 'id_empleado',c.nombre 'nombre_cliente' FROM venta v JOIN empleado e ON v.id_empleado=e.id JOIN cliente c ON c.RFC=v.RFC_cliente";
                    $resultado=mysqli_query($conexion,$op);
                    
                    
                }else if($tipo_cons=="unico-i"){
                    $id=$_POST['id-cons'];
                     $op="SELECT *,v.estatus 'estatus_venta',v.id 'id_venta',e.nombre 'nombre_empleado',e.id 'id_empleado',c.nombre 'nombre_cliente' FROM venta v JOIN empleado e ON v.id_empleado=e.id JOIN cliente c ON c.RFC=v.RFC_cliente WHERE v.id='$id'";
                 $resultado=mysqli_query($conexion,$op);
                        
                    
                    
                    
                    
                }else if($tipo_cons=="rango-fecha"){
                    $fecha_inicial=$_POST['fecha-ini'];
                    $fecha_final=$_POST['fecha-fin'];
                    
                     $op="SELECT *,v.estatus 'estatus_venta',v.id 'id_venta',e.nombre 'nombre_empleado',e.id 'id_empleado',c.nombre 'nombre_cliente' FROM venta v JOIN empleado e ON v.id_empleado=e.id JOIN cliente c ON c.RFC=v.RFC_cliente WHERE v.fecha BETWEEN '$fecha_inicial 00:00:00' AND '$fecha_final 23:59:59'";
                 $resultado=mysqli_query($conexion,$op);
                }else{
                    $fecha=$_POST['fecha-cons'];
                     $op="SELECT *,v.estatus 'estatus_venta',v.id 'id_venta',e.nombre 'nombre_empleado',e.id 'id_empleado',c.nombre 'nombre_cliente' FROM venta v JOIN empleado e ON v.id_empleado=e.id JOIN cliente c ON c.RFC=v.RFC_cliente WHERE v.fecha='$fecha'";
                    $resultado=mysqli_query($conexion,$op);

                }
                
                if($tipo_cons!="unico-i"){
                    while($row=mysqli_fetch_array($resultado)){
                        $id=$row['id_venta'];
                         $fecha=$row['fecha'];
                         $cantidad=$row['cantidad'];
                         $total=$row['total'];
                         $estatus=$row['estatus_venta'];
                        if($estatus){
                            $estatus="en proceso";
                        }else{
                            $estatus="cerrada";
                        }
                       $id_empleado=$row['id_empleado'];
                       $nombre_empleado=$row['nombre_empleado'];
                       $rfc_cliente=$row['RFC_cliente'];
                       $nombre_cliente=$row['nombre_cliente'];
                     
                        $op="SELECT * FROM pieza p JOIN venta_pieza vp ON p.id=vp.id_pieza WHERE vp.id_venta='$id'";
                        $resultado2=mysqli_query($conexion,$op);
                        echo "<tr>
                                <td> $id </td>
                                 <td> $fecha </td>
                                <td> $cantidad </td>
                                <td> $total </td>
                                <td> $estatus </td>
                                <td> $id_empleado </td>
                                <td> $nombre_empleado </td>
                                <td> $rfc_cliente </td>
                                <td> $nombre_cliente </td>
                                ";
                        echo "<td>";
                        if($resultado2){
                        while($row2=mysqli_fetch_array($resultado2)){
                            echo "*".$row2['nombre']." ".$row2['modelo']."--";
                            
                        }
                        }
                        echo "</td>";
                        
                        $op="SELECT *,p.no_serie 'no_serie_producto' FROM producto p JOIN venta_producto vp ON p.no_serie=vp.no_serie WHERE vp.id_venta='$id'";
                       $resultado2=mysqli_query($conexion,$op);
                     
                        echo "<td>";
                        if($resultado2){
                        while($row2=mysqli_fetch_array($resultado2)){
                            echo "*".$row2['no_serie']." ".$row2['nombre_modelo']."--";
                            
                        }
                        }
                        echo "</td></tr>";
                        
                    }
                }else{
                       
                        $row=mysqli_fetch_array($resultado);
                        $id=$row['id_venta'];
                         $fecha=$row['fecha'];
                         $cantidad=$row['cantidad'];
                         $total=$row['total'];
                         $estatus=$row['estatus_venta'];
                        if($estatus){
                            $estatus="en proceso";
                        }else{
                            $estatus="cerrada";
                        }
                       $id_empleado=$row['id_empleado'];
                       $nombre_empleado=$row['nombre_empleado'];
                       $rfc_cliente=$row['RFC_cliente'];
                       $nombre_cliente=$row['nombre_cliente'];
                     
                        $op="SELECT * FROM pieza p JOIN venta_pieza vp ON p.id=vp.id_pieza WHERE vp.id_venta='$id'";
                        $resultado2=mysqli_query($conexion,$op);
                        echo "<tr>
                                <td> $id </td>
                                 <td> $fecha </td>
                                <td> $cantidad </td>
                                <td> $total </td>
                                <td> $estatus </td>
                                <td> $id_empleado </td>
                                <td> $nombre_empleado </td>
                                <td> $rfc_cliente </td>
                                <td> $nombre_cliente </td>
                                ";
                        echo "<td>";
                        if($resultado2){
                        while($row2=mysqli_fetch_array($resultado2)){
                            echo "*".$row2['nombre']." ".$row2['modelo']."--";
                            
                        }
                        }
                        echo "</td>";
                        
                        $op="SELECT *,p.no_serie 'no_serie_producto' FROM producto p JOIN venta_producto vp ON p.no_serie=vp.no_serie WHERE vp.id_venta='$id'";
                       $resultado2=mysqli_query($conexion,$op);
                     
                        echo "<td>";
                        if($resultado2){
                        while($row2=mysqli_fetch_array($resultado2)){
                            echo "*".$row2['no_serie']." ".$row2['nombre_modelo']."--";
                            
                        }
                        }
                        echo "</td></tr>";
                        
                    
                    
                }
             
             
             
             ?>
             
         </table>
         
         
      
    
   
</body>
</html>


<?php mysqli_close($conexion)?>