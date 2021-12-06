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

    <script src="https://kit.fontawesome.com/eefb3f6366.js" crossorigin="anonymous"></script>
</head>
<body>
    
     <main class="contenedor">
         <div class="table-mode">
         <table>
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
         
         
         </div>
    </main>
       
    
   
</body>
</html>


<?php mysqli_close($conexion)?>