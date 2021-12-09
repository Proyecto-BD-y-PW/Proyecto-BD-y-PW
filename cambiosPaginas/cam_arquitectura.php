
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="arquitectura";
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
    <title>Actualizar Arquitecturas</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondoarquitecturas.css">
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

            <div class="header-right">
               <a href="../paginas/arquitecturas.php">
                    <button>REGRESAR</button>
                </a>
                <a href="../funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>
       
   <form action="../mysql/actualizar.php" method="post">
       <div class="formulario">
           <h2>ACTUALIZAR ARQUITECTURA</h2>
           <?php 
            $id=$_POST['id'];
            $op="SELECT * FROM arquitectura WHERE id='$id'";
            $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
            $resultado=mysqli_query($conexion,$op);
            $row=mysqli_fetch_array($resultado);
            
           
           /*libera la memoria*/
           mysqli_free_result( $resultado );
           mysqli_close($conexion);
           
           $id=$row['id'];
           echo "<h3 class='titlePK'>ID: ".$id."</h3><br>";
           
           echo "<input type='hidden' name='id' value='$id'><br>";
           echo "<input class='entrada' type='text' id='tipo' name='tipo' placeholder='".$row['tipo']."' required ><br>";
           echo "<select name='estatus' class='entrada' required>";
           if($row['estatus']==true){
               $estatus='Esta Habilitada la arquitectura';
           }else{
               $estatus='Esta Deshabilitada la arquitectura';
           }
           echo "<option value='' selected disabled>".$estatus."</option>";
           echo "<option value='1'>Habilitar</option>";
           echo "<option value='0'>Deshabilitar</option>";
           echo "</select>";
           
          ?>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
   

   </form>
    
    </main> 
   
</body>
</html>