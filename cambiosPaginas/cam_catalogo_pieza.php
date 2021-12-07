
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="catalogo_pieza";
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
    <title>Actualizar Catálogo De Piezas</title>
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
               <a href="../paginas/catalogo_piezas.php">
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
           <h2>ACTUALIZAR PIEZA EN EL CATÁLOGO</h2>
            <?php
                $nombremodelo=$_POST['nombremodelo'];
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
                $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                $resultado=mysqli_query($conexion,$op);
                $row=mysqli_fetch_array($resultado);
              
               echo "<h3 class='titlePK'>NOMBRE: ".$nombre." MODELO: ".$modelo."</h3><br>";
           
               echo "<input type='hidden' name='nombre' value='$nombre'><br>";
               echo "<input type='hidden' name='modelo' value='$modelo'><br>";
               echo "<input class='entrada' type='text' id='precio_compra' name='precio_compra' placeholder='".$row['precio']."' required >";
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