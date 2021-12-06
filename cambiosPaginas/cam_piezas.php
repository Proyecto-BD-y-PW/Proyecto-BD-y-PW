
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="pieza";
    if($usuario=="" && $pass==""){
        
       echo "<script>
       var reply=confirm('No se ha iniciado sesion');
        if(reply){
            window.location='../index.html';
        
        }
       </script>";
        die();
    }
    
    $privilegios=$_SESSION['privilegios'];
    $acceso_reg="";
    $acceso_elim="";
    $acceso_actua="";
    $acceso_cons="";

    if(strcmp($privilegios,"administrador")==0){
        
    }else if(strcmp($privilegios,"usuario-cap")==0){
        $acceso_elim="disabled";
        $acceso_cons="";
        
    }else{
        $acceso_reg="disabled";
        $acceso_elim="disabled";
        $acceso_actua="disabled";
        
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piezas</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">

    <script src="https://kit.fontawesome.com/eefb3f6366.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <main class="contenedor">
     <input type="checkbox" name="" id="check" checked>

    <header class="site-header">
        
        <div class="site-elements">

            <div class="header-left">
                <label for="check"><i class="fas fa-bars" id="sidebar_btn"></i></label>
                <a href="home.php?op=0"><h1>IGNITION<span> PC</span></h1></a>
            </div>

            <div class="header-right">
               <a href="../paginas/piezas.php">
                    <button>REGRESAR</button>
                </a>
                <a href="funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>

       
   <form action="../mysql/actualizar.php" method="post">
       
        
       <div class="formulario">
           <h2>ACTUALIZAR PIEZA</h2>
           <input class="entrada" type="text" id="id" name="id" placeholder="Ingresa el ID de la pieza" required>
           <?php
           $id=$_POST['id'];
           echo "<h3 class='titlePK'>ID PIEZA: ".$id."</h3><br>";
           
           echo "<input type='hidden' name='id' value='$id'><br>";
           $op="SELECT p.id'id_pieza',p.tipo,p.nombre,p.modelo,p.id_almacen, p.id_compras'id_compras',p.descripcion,c.RFC'rfc',pr.RFC'RFC',pr.empresa'empresa' FROM pieza p JOIN compras c ON p.id_compras=c.id JOIN proveedores pr ON c.RFC=pr.RFC WHERE p.id='$id'";
           $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
           $resultado=mysqli_query($conexion,$op);
           $rowBD=mysqli_fetch_array($resultado);
           
           echo "<select name='idalmacen' id='tipo' class='entrada' required>
                <option value='' selected disabled>".$rowBD['id_almacen']."</option>";
                  
                    $op="SELECT * FROM almacen";
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        echo "<option value='".$i."' >"."*NOMBRE: ".$row['nombre']." *ID:".$row['id']."</option>";
                        
                        
                    }
                
            echo "</select>
            <select name='idcompras' id='tipo' class='entrada' required>
                <option value='' selected disabled>*COMPRA: ".$rowBD['id_compras']." *PROVEEDOR: ".$row['empresa']." *RFC: ".$row['RFC']."</option>";
                 
                    $op="SELECT c.estatus,c.id,p.RFC,p.empresa FROM compras c JOIN proveedores p ON c.RFC=p.RFC";
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        if($row['estatus']){
                            echo "<option value='".$i."' >"."*COMPRA: ".$row['id']." *PROVEEDOR: ".$row['empresa']." *RFC: ".$row['RFC']."</option>";
                        }
                        
                    }
           
            echo "</select>
            <select name='nombremodelo' id='tipo' class='entrada' required>
                <option value='' selected disabled>*Nombre: ".$rowBD['nombre']." *Modelo: ".$rowBD['modelo']."</option>";
                  
                    $op="SELECT * FROM catalogo_pieza";
                    $resultado=mysqli_query($conexion,$op);
                  
                    $separador="*";
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['nombre'];
                        $j=$row['modelo'];
                        
                        echo "<option value='".$i.$separador.$j."' >".$row['nombre']." ".$row['modelo']."</option>";
                        
                        
                    }
                    mysqli_close($conexion);
                
            echo "</select>
            
             <input class='entrada' type='text' id='descripción' name='descripcion' placeholder='".$rowBD['descripcion']."' required>";
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