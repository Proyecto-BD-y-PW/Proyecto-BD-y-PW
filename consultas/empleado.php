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
    <title>Consultas Empleados</title>
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

            <div class="header-right">
               <a href="../paginas/empleados.php">
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
                 <th>NOMBRE</th>
                 <th>ESTATUS</th>
                 <th>TELEFONO</th>
                 <th>CORREO</th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT * FROM empleado";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){
                        $id=$row['id'];
                        $nombre=$row['nombre'];
                        $estatus=$row['estatus'];
                        if($estatus){
                            $estatus="disponible";
                        }else{
                            $estatus="no disponible";
                        }
                        $telefono=$row['telefono'];
                        $correo=$row['correo'];
                        echo "<tr>
                                <td> $id </td>
                                <td> $nombre </td>
                                <td> $estatus </td>
                                <td> $telefono </td>
                                <td> $correo </td>
                        
                        
                            </tr>";
                        
                    }
                    
                }else{
                    $id=$_POST['id'];
                    $op="SELECT * FROM empleado WHERE id='$id'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                    $id=$row['id'];
                    $nombre=$row['nombre'];
                    $estatus=$row['estatus'];
                    if($estatus){
                        $estatus="disponible";
                    }else{
                        $estatus="no disponible";
                    }
                    $telefono=$row['telefono'];
                    $correo=$row['correo'];
                    
                    echo "<tr>
                            <td>$id</td>
                            <td>$nombre</td>
                            <td>$estatus</td>
                            <td>$telefono</td>
                            <td>$correo</td>
                            
                    
                        </tr>";
                    
                    
                }
                
                
             
             
             
             ?>
             
         </table>
         
         
       
       
    
   
</body>
</html>


<?php mysqli_close($conexion)?>