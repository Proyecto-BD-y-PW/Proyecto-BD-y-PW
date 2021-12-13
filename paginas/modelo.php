
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
    <title>Modelo</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondomodelos.css">
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
                <a href="../funciones/closeSession.php">
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
        <a href="arquitecturas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Arquitectura</span></a>
        <a href="ventas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Venta</span></a>
        <a href="empleados.php?op=1"><i class="fas fa-shopping-cart"></i><span>Empleado</span></a>
        <a href="clientes.php?op=1"><i class="fas fa-shopping-cart"></i><span>Cliente</span></a>
        
    </div>

       
   <form action="../mysql/insertar.php" method="post" class="registrar-mode">
       <div class="formulario">
           <h2>REGISTRAR MODELO</h2>
           <input class="entrada" type="text" id="nombre" name="nombre" placeholder="Ingresa el nombre del modelo" required <?php echo $acceso_reg; ?>>
           <select name="id-arquitectura" id="idarquitectura" class="entrada" required <?php echo $acceso_reg; ?>>
               <option value="" selected disabled>Arquitecturas disponibles</option>
                <?php 
                    $op="SELECT * FROM arquitectura";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['id'];
                        echo "<option value='".$i."' >"."*ID: ".$row['id']." *TIPO: ".$row['tipo']."</option>";
                        
                        
                    }
                mysqli_close($conexion);
                ?>
           </select>
           <label for="" class="entrada" id="etiquetasform">Selecciona las piezas que tendra: </label>
          
             <div class="piezas" >
                <ol>
                 <?php 
                    $op="SELECT * FROM catalogo_pieza ORDER BY nombre,modelo ASC";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    $separador="*";
                    $i=1;
                    while($row=mysqli_fetch_array($resultado)){
                        
                        $nombre=$row['nombre'];
                        $modelo=$row['modelo'];
                        $nombremodelo=$nombre.$modelo;
                            echo "<li>
                                <div class='checks'>
                                    <input type='checkbox' name='$i' id='checkboxs'><label for='checkboxs'>$nombre $modelo</label>  
                                </div>
                            </li>";
                        $i++;
                        
                    }
                        mysqli_close($conexion);
                ?>
               
                   
               </ol>
                
            </div>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
   

   </form>
    
    <form action="../mysql/eliminar.php" method="post" class="eliminar-mode">
       <div class="formulario">
           <h2>ELIMINAR MODELO</h2>

            <select name="id-elim" id="elim-dis" class="entrada-1" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Modelo disponibles</option>
                 <?php 
                    $op="SELECT m.nombre,a.id,m.estatus,a.tipo FROM modelo m JOIN arquitectura a ON m.id_arquitectura=a.id";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['nombre'];
                        if($row['estatus']){
                            echo "<option value='".$i."' >"."*NOMBRE: ".$row['nombre']."  *ARQUITECTURA: ".$row['tipo']."</option>";
                        }
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>
            <select name="tipo-elim" id="eliminaciones" class="entrada-1" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Selecciona tipo de eliminacion</option>
                <option value="unico" id="unico">Solo un registro</option>
                <option value="todo" >Eliminar todos los registros</option>
            </select>
    
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
      
     
   </form>
    <form action="../cambiosPaginas/cam_modelo.php" method="post" class="actualizar-mode">
       <div class="formulario">
           <h2>ACTUALIZAR MODELO</h2>
            <select name="id_nombre" id="id" class="entrada" required <?php echo $acceso_actua; ?>>
                <option value="" selected disabled>Modelos disponibles</option>
                <?php 
                    $op="SELECT m.nombre,a.id,m.estatus,a.tipo FROM modelo m JOIN arquitectura a ON m.id_arquitectura=a.id";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['nombre'];
                        if($row['estatus']){
                            echo "<option value='".$i."' >"."*NOMBRE: ".$row['nombre']."  *ARQUITECTURA: ".$row['tipo']."</option>";
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
 <form action="../consultas/modelo.php" method="post" class="consultar-mode">
       <div class="formulario">
           <h2>CONSULTAR MODELO</h2>
           <select name="tipo-cons" id="consultas" class="entrada" required <?php echo $acceso_cons; ?>>
                <option value="" selected disabled>Selecciona tipo de consulta</option>
                <option value="unico" id="unico">Solo un registro</option>
                <option value="todo"  >Consultar todos los registros</option>
                
            </select>
            <select name="id" id="disponibles" class="remove" required <?php echo $acceso_cons; ?>>
                <option value="" selected disabled>Modelos disponibles</option>
                <?php 
                    $op="SELECT m.nombre,a.id,m.estatus,a.tipo FROM modelo m JOIN arquitectura a ON m.id_arquitectura=a.id";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['nombre'];
                            echo "<option value='".$i."' >"."*NOMBRE: ".$row['nombre']."  *ARQUITECTURA: ".$row['tipo']."</option>";
                        
                        
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
  <!---->
    
    
     <div class="radios">
             <img class="entrada" type="radio" id="radio-1" name="radio" this.onclick=null  src="../imagenes/next.png">
             <label for="radio-1"></label>
         </div>
    </main>
 
    <script src="../javascript/opciones.js"></script>

</body>
</html>