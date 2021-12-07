<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="almacen";
    if($usuario=="" && $pass==""){
        
       echo "<script>
       var reply=confirm('No se ha iniciado sesion');
        if(reply){
            window.location='../index.html';
        
        }
       </script>";
        die();
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Almacen</title>
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
    
    
   <form action="../mysql/actualizar.php" method="post" >
          <div class="formulario" >
        <h2>ACTUALIZAR ALMACEN</h2>
        <?php
              $id=$_POST['id'];
              $op="SELECT * FROM almacen WHERE id='$id'";
              $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
              $resultado=mysqli_query($conexion,$op);
              $row=mysqli_fetch_array($resultado);
              
              echo "<h3 class='titlePK'>ID: ".$id." ALMACEN: ".$row['nombre']."</h3><br>";
           
              echo "<input type='hidden' name='id' value='$id'><br>";
              echo "<input class='entrada' type='text' id='nombre' name='n-almacen' placeholder='".$row['nombre']."' required >";
              echo "<input class='entrada' type='text' id='descripción' name='descripcion' placeholder='".$row['descripcion']."' required >";
        
              ?>
               


        
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" >
           <input id="borrar" type="reset" value="BORRAR" class="btn" >  
           
       </div>

   </form>
    </main>
  
</body>
</html>