
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $conexion=$_SESSION['conexion'];
    $_SESSION['pagina']="modelo";
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
    <title>Actualizar Modelo</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondomodelos.css">
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
               <a href="../paginas/modelo.php">
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
           <h2>ACTUALIZAR MODELO</h2>
           <?php
           $idnombre=$_POST['id_nombre'];
           $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
           $op="SELECT m.nombre,m.estatus,m.id_arquitectura,a.tipo FROM modelo m JOIN arquitectura a ON m.id_arquitectura=a.id WHERE nombre='$idnombre'";
           $resultado=mysqli_query($conexion,$op);
           $rowBD=mysqli_fetch_array($resultado);
           
           echo "<input type='hidden' name='idnombre' value='$idnombre'><br>";
           
           echo "<h3 class='titlePK'>NOMBRE DEL MODELO: ".$idnombre."</h3><br>";
           echo "<input class='entrada' type='text' id='nombre' name='nombre' placeholder='".$rowBD['nombre']."' required >
           <select name='id-arquitectura' id='idarquitectura' class='entrada' required >
               <option value='' selected disabled>*ID: ".$rowBD['id_arquitectura']." *TIPO: ".$rowBD['tipo']."</option>";
               
                    $op="SELECT * FROM arquitectura";
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        echo "<option value='".$i."' >"."*ID: ".$row['id']." *TIPO: ".$row['tipo']."</option>"; 
                    }
                mysqli_close($conexion);
           echo "</select>
           <label for='' class='entrada'>Selecciona las piezas que tendra: </label>
          
             <div class='piezas' >
                <ol>";
                    $op="SELECT * FROM catalogo_pieza";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    $separador="*";
                    while($row=mysqli_fetch_array($resultado)){
                        
                        $nombre=$row['nombre'];
                        $modelo=$row['modelo'];
                        
                            echo "<li>
                                <div class='checks'>
                                    <input type='checkbox' name='".$nombre.$separador.$modelo."' id='checkboxs'><label for='checkboxs'>$nombre $modelo</label>  
                                </div>
                            </li>";
                        
                        
                    }
 
                $separador="*";
               
               echo "</ol>
            </div>";
            echo "<select name='estatus' class='entrada' required>";
            if($rowBD['estatus']==true){
                   $estatus='Esta Habilitado el modelo';
            }else{
                   $estatus='Esta Deshabilitado el modelo';
            }
            echo "<option value='' selected disabled>".$estatus."</option>";
            echo "<option value='1'>Habilitar</option>";
            echo "<option value='0'>Deshabilitar</option>";
            echo "</select>";
            mysqli_close($conexion);
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