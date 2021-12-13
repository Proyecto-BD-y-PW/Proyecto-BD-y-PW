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
    <title>Consulta Catálogo Pieza</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link href="https://file.myfontastic.com/zmGVYTk8c485ktmePB4HkF/icons.css" rel="stylesheet">
</head>
<body>
    
     <main class="contenedor">
        <input type="checkbox" name="" id="check" checked>

    <header class="site-header">
        
        <div class="site-elements">

            <div class="header-left">
                <label for="check"><i class="icon-desktop" id="sidebar_btn"></i></label>
                <h1>IGNITION<span> PC</span></h1>
            </div>
            <h1><span> CATALOGO DE PIEZAS</span></h1>
            <div class="header-right">
               <a href="../paginas/catalogo_piezas.php">
                    <button>REGRESAR</button>
                </a>
                <a href="../funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>
         <div class="table-mode">
         <table id="tabla-consultas">
             <tr>
                 <th>NOMBRE</th>
                 <th>MODELO</th>
                 <th>PRECIO</th>
                 
                 
             </tr>
             <?php
                $tipo_cons=$_POST['tipo-cons'];
                if($tipo_cons=="todo"){
                    $op="SELECT * FROM catalogo_pieza";
                    $resultado=mysqli_query($conexion,$op);
                    while($row=mysqli_fetch_array($resultado)){
                        $nombre=$row['nombre'];
                        $modelo=$row['modelo'];
                        $precio=$row['precio'];
                        echo "<tr>
                                <td> $nombre </td>
                                <td> $modelo </td>
                                <td> $$precio </td>
                                
                        
                            </tr>";
                        
                    }
                    
                }else{
                    $nombremodelo=$_POST['id'];
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
                    }
                    
                    $op="SELECT * FROM catalogo_pieza WHERE nombre='$nombre' AND modelo='$modelo'";
                    $resultado=mysqli_query($conexion,$op);
                    $row=mysqli_fetch_array($resultado);
                    $nombre=$row['nombre'];
                    $modelo=$row['modelo'];
                    $precio=$row['precio'];
                       
                    echo "<tr>
                            <td>$nombre</td>
                            <td>$modelo</td>
                            <td>$$precio</td>
                            
                    
                        </tr>";
                    
                    
                }
                
                
             
             
             
             ?>
             
         </table>
         
         
         </div>
    </main>
       
    
   
</body>
</html>


<?php mysqli_close($conexion)?>