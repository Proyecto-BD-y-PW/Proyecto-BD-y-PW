<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="venta";
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
    <title>Actualizar Ventas</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondoventas.css">
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
               <a href="../paginas/ventas.php">
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
           <h2>ACTUALIZAR VENTA</h2>
           <!--Recordar que el ID de la ventas es automatica-->
           <!--Cantidad y total calculados de ventas-->
           <?php
           $id=$_POST['id_ventas'];
           $op="SELECT v.id'id_venta',v.estatus'estatus',v.fecha,c.RFC'RFC_cliente',c.nombre'nombre_cliente',e.id'id_empleado',e.nombre'nombre_empleado' FROM venta v JOIN cliente c ON v.RFC_cliente=c.RFC JOIN empleado e ON e.id=v.id_empleado WHERE v.id='$id'";
           $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
           $resultado=mysqli_query($conexion,$op);
           $rowBD=mysqli_fetch_array($resultado);
           echo "<h3 class='titlePK'>ID VENTA: ".$id."</h3><br>";
           
           echo "<input type='hidden' name='id' value='$id'><br>";
           echo "<select name='rfc' id='id' class='entrada' required >
                <option value='' selected disabled>*RFC: ".$rowBD['RFC_cliente']." *Cliente: ".$rowBD['nombre_cliente']."</option>";
                
                    $op="SELECT v.id'id_venta',c.RFC,c.nombre 'nombre_cliente',e.id,e.nombre'nombre_empleado' FROM venta v JOIN cliente c ON v.RFC_cliente=c.RFC JOIN empleado e ON e.id=v.id_empleado";
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['RFC'];
                        echo "<option value='".$i."' >"."RFC: ".$row['RFC']." *NOMBRE: ".$row['nombre_cliente']."</option>";
                        
                        
                    }
                    mysqli_close($conexion);
                
           echo "</select>
           <select name='idempleado' id='idempleado' class='entrada' required >
                <option value='' selected disabled>*EMLEADO: ".$rowBD['nombre_empleado']."*ID: ".$rowBD['id_empleado']."</option>";
                
                    $op="SELECT * FROM empleado";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        if($row['estatus']){
                            echo "<option value='".$i."' >"."Empleado: ".$row['nombre']." ID: ".$row['id']."</option>";
                        }
                        
                    }
                    
                
           echo "</select>
           <label for='' class='entrada'>Ingresar Fecha y Hora de la venta: ".$rowBD['fecha']."</label>
           <input class='entrada' type='date' id='fecha' name='fecha' placeholder='Ingresa la fecha de la compra' required>
           <input class='entrada' type='time' id='hora' name='hora' placeholder='Ingresa la hora de la compra' required>";
           echo "<select name='estatus' class='entrada' required>";
           if($rowBD['estatus']==true){
               $estatus='Esta Habilitada la venta';
           }else{
               $estatus='Esta Deshabilitada la venta';
           }
           echo "<option value='' selected disabled>".$estatus."</option>";
           echo "<option value='1'>Habilitar</option>";
           echo "<option value='0'>Deshabilitar</option>";
           echo "</select>";
           mysqli_close($conexion);
           ?>
 
       </div>

       <div class="botones" >
           <input id="enviar" type="submit" value="Enviar" class="btn" >
           <input id="borrar" type="reset" value="BORRAR" class="btn" >  
           
       </div>
   

   </form>

    </main>

</body>
</html>