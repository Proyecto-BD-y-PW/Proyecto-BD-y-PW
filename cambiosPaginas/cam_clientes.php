<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="cliente";

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
    <title>Actualizar Clientes</title>
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
               <a href="../paginas/clientes.php">
                    <button>REGRESAR</button>
                </a>
                <a href="../funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>
    
   <form action="../mysql/actualizar.php" method="post" >
       <div class="formulario">
       <?php 
            $rfc=$_POST['rfc'];
            $op="SELECT * FROM cliente WHERE RFC='$rfc'";
            $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            
           
           /*libera la memoria*/
           mysqli_free_result( $resultado );
           mysqli_close($conexion);
        ?>
       <h2>ACTUALIZAR EL CLIENTE</h2>
           <?php
           $rfc=$row['RFC'];
           echo "<h3 class='titlePK'>RFC: ".$rfc."</h3><br>";
           
           echo "<input type='hidden' name='rfc' value='$rfc'><br>";
           echo "<input class='entrada' type='text' id='rfc' name='rfccamb' placeholder='".$row['RFC']."' required ><br>";
           echo "<input class='entrada' type='text' id='nombre' name='nombre' placeholder='".$row['nombre']."' required ><br>";
           echo "<input class='entrada' type='text' id='telefono' name='telefono' placeholder='".$row['telefono']."' required ><br>";
           echo "<input class='entrada' type='email' id='correo' name='correo' placeholder='".$row['email']."' required ><br>";
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