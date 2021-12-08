
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
               <a href="../paginas/perfil.php">
                    <button>PERFIL DEL USUARIO</button>
                </a>
                <a href="funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>
     <div class="sidebar">

        <div class="profile-data">
           
        </div>

<a href="proveedores.php?op=1"><i class="fas fa-shopping-cart"></i><span>Proveedores</span></a>
        <a href="compras.php?op=1"><i class="fas fa-shopping-cart"></i><span>Compras</span></a>
        <a href="almacen.php?op=1"><i class="fas fa-shopping-cart"></i><span>Almacen</span></a>
        <a href="piezas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Piezas</span></a>
        <a href="pieza_venta.php?op=1"><i class="fas fa-shopping-cart"></i><span>Piezas de venta</span></a>
        <a href="catalogo_piezas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Catálogo de Piezas</span></a>
        <a href="productos.php?op=1"><i class="fas fa-shopping-cart"></i><span>Productos</span></a>
        <a href="modelo.php?op=1"><i class="fas fa-shopping-cart"></i><span>Modelo</span></a>
        <a href="arquitecturas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Arquitecura</span></a>
        <a href="ventas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Venta</span></a>
        <a href="empleados.php?op=1"><i class="fas fa-shopping-cart"></i><span>Empleado</span></a>
        <a href="clientes.php?op=1"><i class="fas fa-shopping-cart"></i><span>Cliente</span></a>
        
    </div>

       
   <form action="../mysql/insertar.php" method="post" class="registrar-mode">
       
        
       <div class="formulario">
           <h2>REGISTRAR PIEZAS</h2>
           <input class="entrada" type="text" id="id" name="id" placeholder="Ingresa el ID de la pieza" required <?php echo $acceso_reg; ?>>
           <select name="idalmacen" id="tipo" class="entrada" required <?php echo $acceso_reg; ?>>
                <option value="" selected disabled>Almacen donde se guardara</option>
                 <?php 
                    $op="SELECT * FROM almacen";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        echo "<option value='".$i."' >"."*NOMBRE: ".$row['nombre']." *ID:".$row['id']."</option>";
                        
                        
                    }
                mysqli_close($conexion);
                ?>
            </select>
            <select name="idcompras" id="tipo" class="entrada" required <?php echo $acceso_reg; ?>>
                <option value="" selected disabled>Compra a la que pertenece</option>
                 <?php 
                    $op="SELECT c.estatus,c.id,p.RFC,p.empresa FROM compras c JOIN proveedores p ON c.RFC=p.RFC";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        if($row['estatus']){
                            echo "<option value='".$i."' >"."*COMPRA: ".$row['id']." *PROVEEDOR: ".$row['empresa']." *RFC: ".$row['RFC']."</option>";
                        }
                        
                    }
                mysqli_close($conexion);
                ?>
            </select>
            
            <select name="nombremodelo" id="tipo" class="entrada" required <?php echo $acceso_reg; ?>>
                <option value="" selected disabled>Seleccion el nombre y modelo</option>
                 <?php 
                    $op="SELECT * FROM catalogo_pieza";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    $separador="*";
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['nombre'];
                        $j=$row['modelo'];
                        
                        echo "<option value='".$i.$separador.$j."' >".$row['nombre']." ".$row['modelo']."</option>";
                        
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>
            
             <input class="entrada" type="text" id="descripción" name="descripcion" placeholder="Ingresa la descripción de la pieza" required <?php echo $acceso_reg; ?>>
           
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_reg ;?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_reg ;?>>  
           
       </div>
   </form>
    
    <form action="../mysql/eliminar.php" method="post" class="eliminar-mode">
       <div class="formulario">
          <h2>ELIMINAR PIEZAS</h2>

             <select name="id-elim" id="elim-id" class="remove" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Piezas disponibles</option>
                 <?php 
                    $op="SELECT * FROM pieza";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];

                        if($row['en_almacen']){
                            echo "<option value='".$i."' >"."*ID: ".$row['id']."  *NOMBRE: ".$row['nombre']." *MODELO: ".$row['modelo']."</option>";
                        }
                        
                    }

                    mysqli_close($conexion);
                ?>
            </select>
             <select name="fecha" id="elim-fecha" class="remove" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Fechas registradas</option>
                 <?php 
                    $op="SELECT distinct c.fecha,p.en_almacen FROM pieza p JOIN compras c ON p.id_compras=c.id";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['fecha'];
                        if($row['en_almacen']){
                            echo "<option value='".$i."' >"."*FECHA: ".$row['fecha']."</option>";
                        }
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>
            <select name="tipo-elim" id="eliminaciones" class="entrada-1" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Selecciona tipo de eliminacion</option>
                <option value="unico-id" id="unico">Solo un registro por su id</option>
                <option value="unico-fecha" id="unico">Registros con una fecha en especifico</option>
                <option value="todo" >Eliminar todos los registros</option>
            </select>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_elim ;?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_elim ;?>>  
           
       </div>
      
     
   </form>
    <form action="../cambiosPaginas/cam_piezas.php" method="post" class="actualizar-mode">
       <div class="formulario">
           <h2>ACTUALIZAR PIEZAS</h2>
           <?php
            echo "<select name='id' id='id' class='entrada' required $acceso_actua>
                <option value='' selected disabled>Piezas disponibles</option>";
                $op="SELECT * FROM pieza";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];

                        
                            echo "<option value='".$i."' >"."*ID: ".$row['id']."  *NOMBRE: ".$row['nombre']." *MODELO: ".$row['modelo']."</option>";     
                    }
            echo "</select>";
            ?>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_actua ;?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_actua ;?>>  
           
       </div>
      
     
   </form>
 <form action="../consultas/pieza.php" method="post" class="consultar-mode">
       <div class="formulario">
           <h2>CONSULTAR PIEZAS</h2>
            <select name="tipo-cons" id="consultas" class="entrada" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Selecciona tipo de consulta</option>
                <option value="unico-i" id="unico-id">Solo un registro por su id</option>
                <option value="unico-f" id="unico-fecha">Registros con una fecha en especifico</option>
                <option value="rango-fecha" id="rango-fecha">Mostrar registros por un rango de fecha</option>
                <option value="todo" >Consultar todos los registros</option>
            </select>
              <select name="id-cons" id="consultas-id" class="remove" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Piezas disponibles</option>
                 <?php 
                    $op="SELECT * FROM pieza ";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                            echo "<option value='".$i."' >"."*ID: ".$row['id']." *PIEZA: ".$row['nombre']." ".$row['modelo']."</option>";
                       
                    }
                    mysqli_close($conexion);
                ?>
            </select>
             <select name="fecha-cons" id="consultas-fecha" class="remove" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Fechas registradas al entrar al almacen</option>
                 <?php 
                    $op="SELECT distinct c.fecha FROM pieza p JOIN compras c ON c.id=p.id_compras";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['fecha'];
                             echo "<option value='".$i."' >"."*FECHA: ".$row['fecha']."</option>";
                        
                    }
                    mysqli_close($conexion);
                ?>
           </select>
           <p id="fecha" class="remove">Ingresa fecha inicial</p>
            <input type="date" name="fecha-ini"  id="fecha" class="remove" required <?php echo $acceso_cons ;?>>
            <p id="fecha" class="remove">Ingresa fecha final</p>
            <input type="date" name="fecha-fin" id="fecha" class="remove" placeholder="in" required <?php echo $acceso_cons ;?>>

           
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_cons ;?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_cons ;?>>  
           
       </div>
      
     
   </form>
    
    
     <div class="radios">
             <img class="entrada" type="radio" id="radio-1" name="radio" this.onclick=null  src="../imagenes/next.png">
             <label for="radio-1"></label>
         </div>
    </main>
       
       
        
        
    
    <script src="../javascript/ventas.js"></script>
</body>
</html>