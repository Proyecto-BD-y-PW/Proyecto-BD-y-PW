
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="producto";
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
    <title>Productos</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondoproductos.css">
    <script src="https://kit.fontawesome.com/eefb3f6366.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <main class="contenedor">
     <input type="checkbox" name="" id="check" checked>

    <header class="site-header">
        
        <div class="site-elements">

            <div class="header-left">
                <label for="check"><i class="fas fa-bars" id="sidebar_btn"></i></label>
                <h1>IGNITION<span> PC</span></h1>
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
           <h2>REGISTRAR PRODUCTOS</h2>
           <input class="entrada" type="text" id="nserie" name="nserie" placeholder="Ingresa el Numero de serie del producto" required <?php echo $acceso_reg ;?>>
        <!--Status en almacen no creo que pueda ser bueno ya que el No.Serie no se repite para ningun producto-->
           <input class="entrada" type="text" id="descripción" name="descripcion" placeholder="Ingresa la descripción del producto" required <?php echo $acceso_reg ;?>>
           <p>Ingresar Fecha y Hora del producto llegado al almacen: </p>
           <input class="entrada" type="date" id="fecha" name="fecha" placeholder="Ingresa la fecha de la compra" required <?php echo $acceso_reg ;?>>
           <input class="entrada" type="time" id="hora" name="hora" placeholder="Ingresa la hora de la compra" required <?php echo $acceso_reg ;?>>
           <input class="entrada" type="text" id="costo" name="costo" placeholder="Ingresa el costo del producto" required <?php echo $acceso_reg ;?>>
           <!--El ID del almacen es predeterminado al macen de productos-->
             <select name="idalmacen" id="idalmacen" class="entrada" required <?php echo $acceso_reg ;?>>
                <option value="" selected disabled>Almacenes disponibles</option>
                 
               <?php 
                    $op="SELECT * FROM almacen";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        echo "<option value='".$i."' >"."*ID: ".$row['id']." *NOMBRE: ".$row['nombre']."</option>";
                        
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>
             <select name="modelo" id="modelo" class="entrada" required <?php echo $acceso_reg ;?>>
                <option value="" selected disabled>Modelos disponibles</option>
                <?php 
                    $op="SELECT m.estatus, m.nombre,a.tipo FROM modelo m JOIN arquitectura a ON m.id_arquitectura=a.id";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                    $band=true;
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['nombre'];
                        if($row["estatus"]){
                            $op="SELECT * FROM modelo m JOIN pieza_modelo pm ON m.nombre=pm.nombre_modelo WHERE m.nombre='$i'";
                            $resultado2=mysqli_query($conexion,$op);
                            $numero=mysqli_num_rows($resultado2);
                            
                               $nombre=$row2['nombre_pieza'];
                                $modelo=$row2['modelo_pieza'];
                                $op="SELECT DISTINCT p.nombre, p.modelo FROM pieza p JOIN pieza_modelo pm ON p.nombre=pm.nombre_pieza AND p.modelo=pm.modelo_pieza WHERE pm.nombre_modelo='$i' AND p.en_almacen='1'";
                                $resultado2=mysqli_query($conexion,$op);
                                $numero_piezas=mysqli_num_rows($resultado2);
                                if($numero_piezas>=$numero){
                                    echo "<option value='".$i."' >"."*MODELO: ".$row['nombre']." *ARQUITECTURA: ".$row['tipo']."</option>";
                           
                                }else {
                                    echo "<option value='".$i."' disabled>"."*MODELO: ".$row['nombre']." *ARQUITECTURA: ".$row['tipo']." Sin piezas en stock</option>";
                           
                                    
                                }
                             
                            
                         }
                        
                    }
                    mysqli_close($conexion);
                ?>
               
            </select>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
   

   </form>
    
    <form action="../mysql/eliminar.php" method="post" class="eliminar-mode">
       <div class="formulario">
            <h2>ELIMINAR PRODUCTOS</h2>

            <select name="id-elim" id="elim-id" class="remove" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Computadoras disponibles</option>
                 <?php 
                    $op="SELECT * FROM producto";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['no_serie'];
                        if($row['en_almacen']){
                            echo "<option value='".$i."' >"."*NO DE SERIE: ".$row['no_serie']."  *MODELO: ".$row['nombre_modelo']."</option>";
                        }
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>
            <select name="fecha" id="elim-fecha" class="remove" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Fechas registradas</option>
                 <?php 
                    $op="SELECT distinct fecha,en_almacen FROM producto";
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
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
      
     
   </form>
    <form action="enviar.php" method="post" class="actualizar-mode">
       <div class="formulario">
           <h2>ACTUALIZAR PRODUCTOS</h2>
            <select name="serie" id="serie" class="entrada" <?php echo $acceso_actua ;?>>
                <option value="" selected disabled>Computadoras disponibles</option>
                
            </select>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
      
     
   </form>
 <form action="../consultas/producto.php" method="post" class="consultar-mode">
       <div class="formulario">
           <h2>CONSULTAR PRODUCTOS</h2>
            
            
            <select name="tipo-cons" id="consultas" class="entrada" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Selecciona tipo de consulta</option>
                <option value="unico-i" id="unico-id">Solo un registro por su numero de serie</option>
                <option value="unico-f" id="unico-fecha">Registros con una fecha en especifico</option>
                <option value="rango-fecha" id="rango-fecha">Mostrar registros por un rango de fecha</option>
                <option value="todo" >Consultar todos los registros</option>
            </select>
              <select name="id-cons" id="consultas-id" class="remove" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Computadoras disponibles</option>
                 <?php 
                    $op="SELECT * FROM producto ";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['no_serie'];
                            echo "<option value='".$i."' >"."*NO DE SERIE: ".$row['no_serie']." *MODELO: ".$row['nombre_modelo']."</option>";
                       
                    }
                    mysqli_close($conexion);
                ?>
            </select>
             <select name="fecha-cons" id="consultas-fecha" class="remove" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Fechas registradas al entrar al almacen</option>
                 <?php 
                    $op="SELECT distinct fecha FROM producto";
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
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
      
     
   </form>
  <!---->
    
    
     <div class="radios">
             <img class="entrada" type="radio" id="radio-1" name="radio" this.onclick=null  src="../imagenes/next.png">
             <label for="radio-1"></label>
         </div>
    </main>  
    
    
    <script src="../javascript/ventas.js"></script>
</body>
</html>