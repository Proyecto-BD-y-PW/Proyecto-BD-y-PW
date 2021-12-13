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
    <title>Consulta Producto</title>
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
            <h1> <span>PIEZAS EN GENERAL</span> </h1>
            <div class="header-right">
               <a href="../paginas/productos.php">
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
                 <th>NO DE SERIE</th>
                  <th>ESTATUS</th>
                 <th>DESCRIPCION</th>
                 <th>FECHA</th>
                 <th>PRECIO AL PUBLICO</th>
                 <th>ID DEL ALMACEN</th>
                  <th>NOMBRE DEL ALMACEN</th>
                 <th>MODELO</th>
                 <th>ARQUITECTURA</th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT *,a.nombre 'nombre_almacen' FROM producto p JOIN almacen a ON p.id_almacen=a.id JOIN modelo m ON p.nombre_modelo=m.nombre JOIN arquitectura ar ON ar.id=m.id_arquitectura";
                    $resultado=mysqli_query($conexion,$op);
                    
                    
                }else if($tipo_cons=="unico-i"){
                    $id=$_POST['id-cons'];
                    $op="SELECT *,a.nombre 'nombre_almacen' FROM producto p JOIN almacen a ON p.id_almacen=a.id JOIN modelo m ON p.nombre_modelo=m.nombre JOIN arquitectura ar ON ar.id=m.id_arquitectura WHERE no_serie='$id'";
                    $resultado=mysqli_query($conexion,$op);
                        
                    
                    
                    
                    
                }else if($tipo_cons=="rango-fecha"){
                    $fecha_inicial=$_POST['fecha-ini'];
                    $fecha_final=$_POST['fecha-fin'];
                    
                    $op="SELECT *,a.nombre 'nombre_almacen' FROM producto p JOIN almacen a ON p.id_almacen=a.id JOIN modelo m ON p.nombre_modelo=m.nombre JOIN arquitectura ar ON ar.id=m.id_arquitectura WHERE p.fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";
                    $resultado=mysqli_query($conexion,$op);
                }else{
                    $fecha=$_POST['fecha-cons'];
                    $op="SELECT *,a.nombre 'nombre_almacen' FROM producto p JOIN almacen a ON p.id_almacen=a.id JOIN modelo m ON p.nombre_modelo=m.nombre JOIN arquitectura ar ON ar.id=m.id_arquitectura WHERE p.fecha='$fecha'";
                    $resultado=mysqli_query($conexion,$op);
                    
                }
                
                if($tipo_cons!="unico-i"){
                    while($row=mysqli_fetch_array($resultado)){
                        $no_serie=$row['no_serie'];
                         $estatus=$row['en_almacen'];
                        if($estatus){
                            $estatus="en almacen";
                        }else{
                            $estatus="fuera de almacen";
                        }
                        $descripcion=$row['descripcion'];
                        $fecha=$row['fecha'];
                        $precio_publico=$row['costo'];
                        $id_almacen=$row['id_almacen'];
                        $nombre_almacen=$row['nombre_almacen'];
                        $modelo=$row['nombre_modelo'];
                        $tipo=$row['tipo'];
                       
                        echo "<tr>
                                <td> $no_serie </td>
                                 <td> $estatus </td>
                                <td> $descripcion </td>
                                <td> $fecha </td>
                                <td> $precio_publico </td>
                                <td> $id_almacen </td>
                                <td> $nombre_almacen </td>
                                <td> $modelo </td>
                                <td> $tipo </td>
                                
                        
                            </tr>";
                        
                    }
                }else{
                        $row=mysqli_fetch_array($resultado);
                        $no_serie=$row['no_serie'];
                         $estatus=$row['en_almacen'];
                        if($estatus){
                            $estatus="en almacen";
                        }else{
                            $estatus="fuera de almacen";
                        }
                        $descripcion=$row['descripcion'];
                        $fecha=$row['fecha'];
                        $precio_publico=$row['costo'];
                        $id_almacen=$row['id_almacen'];
                        $nombre_almacen=$row['nombre_almacen'];
                        $modelo=$row['nombre_modelo'];
                        $tipo=$row['tipo'];
                       
                        echo "<tr>
                                <td> $no_serie </td>
                                 <td> $estatus </td>
                                <td> $descripcion </td>
                                <td> $fecha </td>
                                <td> $precio_publico </td>
                                <td> $id_almacen </td>
                                <td> $nombre_almacen </td>
                                <td> $modelo </td>
                                <td> $tipo </td>
                                
                        
                            </tr>";
                        
                    
                }
             
             
             
             ?>
             
         </table>
         
         
      
    
   
</body>
</html>


<?php mysqli_close($conexion)?>