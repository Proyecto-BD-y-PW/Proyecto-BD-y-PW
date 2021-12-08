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
                <a href="home.php?op=0"><h1>IGNITION<span> PC</span></h1></a>
            </div>

            <div class="header-right">
               <a href="../paginas/almacen.php">
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
                 <th>DESCRIPCION</th>
                 <th>CAPITAL</th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT * FROM almacen";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){
                        $id=$row['id'];
                        $nombre=$row['nombre'];
                        $descripcion=$row['descripcion'];
                        $capital=$row['capital'];
                        echo "<tr>
                                <td> $id </td>
                                <td> $nombre </td>
                                <td> $descripcion </td>
                                <td> $capital </td>
                        
                        
                            </tr>";
                        
                    }
                    
                }else{
                    $id=$_POST['id'];
                    $op="SELECT * FROM almacen WHERE id='$id'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                    $id=$row['id'];
                    $nombre=$row['nombre'];
                    $descripcion=$row['descripcion'];
                    $capital=$row['capital'];
                    
                    echo "<tr>
                            <td>$id</td>
                            <td>$nombre</td>
                            <td>$descripcion</td>
                            <td>$capital</td>
                            
                    
                        </tr>";
                    
                    
                }
                
                
             
             
             
             ?>
             
         </table>
         <!--tabla que se encarga de imprimir las piezas y los productos-->
         <table id="tabla-consultas" >
             <tr>
                 <th>ID</th>
                 <th>NOMBRE</th>
                 <th>PIEZAS</th>
                 <th>PRODUCTOS </th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT * FROM ALMACEN  ";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){
                        $id=$row['id'];
                        $nombre=$row['nombre'];
                         $capital=$row['capital'];
                        echo "<tr>
                                <td> $id </td>
                                <td> $nombre </td>
                                <td>"; 
                        $op="SELECT *,a.nombre 'nombre_almacen',p.id 'id_pieza' FROM almacen a JOIN pieza p ON a.id=p.id_almacen WHERE p.id_almacen='$id'";
                        $resultado2=mysqli_query($conexion,$op);
                                
                        while($row2=mysqli_fetch_array($resultado2)){
                            if($row2['en_almacen']){
                                echo "*ID: ".$row2['id_pieza']." ".$row2['nombre']." ".$row2['modelo']." - ";
                            }
                        }
                        
                        echo "</td>";
                        echo "<td>";
                        $op="SELECT *,a.nombre 'nombre_almacen',p.no_serie FROM almacen a JOIN producto p ON a.id=p.id_almacen WHERE p.id_almacen='$id'";
                        $resultado2=mysqli_query($conexion,$op);
                                
                        while($row2=mysqli_fetch_array($resultado2)){
                            if($row2['en_almacen']){
                                echo "*NO SERIE: ".$row2['no_serie']." ".$row2['nombre_modelo']." - ";
                            }
                            
                        }
                        echo "</td></tr>";
                    }
                    
                }else{
                    $id=$_POST['id'];                  
                    $op="SELECT * FROM ALMACEN  WHERE id='$id'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                        $id=$row['id'];
                        $nombre=$row['nombre'];
                         $capital=$row['capital'];
                        echo "<tr>
                                <td> $id </td>
                                <td> $nombre </td>
                                <td>"; 
                        $op="SELECT *,a.nombre 'nombre_almacen',p.id 'id_pieza' FROM almacen a JOIN pieza p ON a.id=p.id_almacen WHERE p.id_almacen='$id'";
                        $resultado2=mysqli_query($conexion,$op);
                                
                        while($row2=mysqli_fetch_array($resultado2)){
                            
                            if($row2['en_almacen']){
                                echo "*ID: ".$row2['id_pieza']." ".$row2['nombre']." ".$row2['modelo']." - ";
                            }
                            
                        }
                        
                        echo "</td>";
                        echo "<td>";
                        $op="SELECT *,a.nombre 'nombre_almacen',p.no_serie FROM almacen a JOIN producto p ON a.id=p.id_almacen WHERE p.id_almacen='$id'";
                        $resultado2=mysqli_query($conexion,$op);
                                
                        while($row2=mysqli_fetch_array($resultado2)){
                            if($row2['en_almacen']){
                                echo "*NO SERIE: ".$row2['no_serie']." ".$row2['nombre_modelo']." - ";
                            
                            }
                        }
                        echo "</td></tr>";
                    
                    
                    
                }
                
                
             
             
             
             ?>
             
         </table>
         
         
       <!--  </div>
    </main>
       -->
    
   
</body>
</html>


<?php mysqli_close($conexion)?>