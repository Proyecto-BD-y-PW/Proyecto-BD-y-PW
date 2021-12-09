
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="compra";
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
    <title>Actualizar Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondocompras.css">
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
               <a href="../paginas/compras.php">
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
           <h2>ACTUALIZAR COMPRAS</h2>
           <!--El id es autoincrementable-->
           
           <?php
           $id=$_POST['id'];
           $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
           $op="SELECT * FROM compras WHERE id='$id'";
           $resultado=mysqli_query($conexion,$op);
           $rowBD=mysqli_fetch_array($resultado);
           $RFC=$rowBD['RFC'];
           
           echo "<h3 class='titlePK'>ID COMPRA: ".$id."</h3><br>";
           
           echo "<input type='hidden' name='id' value='$id'><br>";
           
           $op="SELECT * FROM proveedores WHERE RFC='$RFC'";
           $resultado=mysqli_query($conexion,$op);
           $row=mysqli_fetch_array($resultado);
           
           echo "<label for='' class='entrada'>Ingresar Fecha y Hora de la compra: ".$rowBD['fecha']."</label>
           <input class='entrada' type='date' id='fecha' name='fecha' required >
           <input class='entrada' type='time' id='hora' name='hora' placeholder='Ingresa la hora de la compra' required >
           <select name='rfc_proveedor' id='rfc'>
               <option value='' selected disabled>*PROVEEDOR: ".$row['empresa']." *RFC: ".$row['empresa']."</option>";
                    
                    $op="SELECT * FROM proveedores";
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['RFC'];
                        if($row['estatus']){
                            echo "<option value='".$i."' >"."*PROVEEDOR: ".$row['empresa']." *RFC: ".$row['RFC']."</option>";
                        }
                        
                    }
                    mysqli_close($conexion);
               
           echo "</select>";
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