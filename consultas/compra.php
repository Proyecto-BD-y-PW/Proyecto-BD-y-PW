<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="proveedor";
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
    <title>Inventarios</title>
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
                <a href="home.php?op=0"><h1>IGNITION<span> PC</span> </h1></a>
                <!--
               --> 
            </div>
            <h1> <span>COMPRAS</span> </h1>
            <div class="header-right">
               <a href="../paginas/compras.php">
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
                 <th>FECHA</th>
                 <th>CANTIDAD</th>
                 <th>PRECIO</th>
                 <th>ESTATUS</th>
                 <th>EMPRESA</th>
                 <th>RFC</th>
                 <th>VENDEDOR</th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT *,p.RFC 'RFC_proveedor' FROM compras c JOIN proveedores p ON c.RFC=p.RFC";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){
                        $id=$row['id'];
                        $fecha=$row['fecha'];
                        $cantidad=$row['cantidad'];
                        $precio=$row['precio'];
                        $estatus=$row['estatus'];
                        if($estatus){
                            $estatus="terminada";
                        }else{
                            $estatus="en proceso";
                        }
                         $empresa=$row['empresa'];
                        $rfc=$row['RFC_proveedor'];
                        $nombre=$row['nombre_proveedor'];
                        echo "<tr>
                                <td> $id </td>
                                <td> $fecha </td>
                                <td> $cantidad </td>
                                <td> $precio </td>
                                <td> $estatus </td>
                                <td> $empresa </td>
                                <td> $rfc </td>
                                <td> $nombre </td>
                        
                        
                            </tr>";
                        
                    }
                    
                }else if($tipo_cons=="unico-i"){
                    $id=$_POST['id-cons'];
                    $op="SELECT * FROM compras WHERE id='$id'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                    $id=$row['RFC'];
                    $op="SELECT *,p.RFC 'RFC_proveedor' FROM compras c JOIN proveedores p ON p.RFC='$id'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                        $id=$row['id'];
                        $fecha=$row['fecha'];
                        $cantidad=$row['cantidad'];
                        $precio=$row['precio'];
                        $estatus=$row['estatus'];
                        if($estatus){
                            $estatus="terminada";
                        }else{
                            $estatus="en proceso";
                        }
                         $empresa=$row['empresa'];
                        $rfc=$row['RFC_proveedor'];
                        $nombre=$row['nombre_proveedor'];
                    
                    echo "<tr>
                                <td> $id </td>
                                <td> $fecha </td>
                                <td> $cantidad </td>
                                <td> $precio </td>
                                <td> $estatus </td>
                                <td> $empresa </td>
                                <td> $rfc </td>
                                <td> $nombre </td>
                    
                        </tr>";
                    
                    
                }else if($tipo_cons=="rango-fecha"){
                    $fecha_inicial=$_POST['fecha-ini'];
                    $fecha_final=$_POST['fecha-fin'];
                     $op="SELECT *,p.RFC 'RFC_proveedor' FROM compras c JOIN proveedores p ON p.RFC=c.RFC WHERE fecha BETWEEN '$fecha_inicial 00:00:00' AND '$fecha_final 23:59:59'";
                    $resultado=mysqli_query($conexion,$op);
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $id=$row['id'];
                        $fecha=$row['fecha'];
                        $cantidad=$row['cantidad'];
                        $precio=$row['precio'];
                        $estatus=$row['estatus'];
                        if($estatus){
                            $estatus="terminada";
                        }else{
                            $estatus="en proceso";
                        }
                         $empresa=$row['empresa'];
                        $rfc=$row['RFC_proveedor'];
                        $nombre=$row['nombre_proveedor'];
                    
                    echo "<tr>
                                <td> $id </td>
                                <td> $fecha </td>
                                <td> $cantidad </td>
                                <td> $precio </td>
                                <td> $estatus </td>
                                <td> $empresa </td>
                                <td> $rfc </td>
                                <td> $nombre </td>
                    
                        </tr>";
                    
                            
                        
                    }
                    
                    
                    
                }else{
                    $fecha=$_POST['fecha-cons'];
                    
                    $op="SELECT * FROM compras WHERE fecha='$fecha'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                    $id=$row['RFC'];
                    
                    $op="SELECT *,p.RFC 'RFC_proveedor' FROM compras c JOIN proveedores p ON p.RFC='$id' AND c.fecha='$fecha'";
                    $resultado=mysqli_query($conexion,$op);
                      
                        
                      while($row=mysqli_fetch_array($resultado)){  
                         $id=$row['id'];
                        $fecha=$row['fecha'];
                        $cantidad=$row['cantidad'];
                        $precio=$row['precio'];
                        $estatus=$row['estatus'];
                        if($estatus){
                            $estatus="terminada";
                        }else{
                            $estatus="en proceso";
                        }
                         $empresa=$row['empresa'];
                        $rfc=$row['RFC_proveedor'];
                        $nombre=$row['nombre_proveedor'];
                        echo "<tr>
                                <td> $id </td>
                                <td> $fecha </td>
                                <td> $cantidad </td>
                                <td> $precio </td>
                                <td> $estatus </td>
                                <td> $empresa </td>
                                <td> $rfc </td>
                                <td> $nombre </td>
                    
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